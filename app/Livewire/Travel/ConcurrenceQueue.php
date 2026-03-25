<?php

namespace App\Livewire\Travel;

use App\Models\ConcurrenceStep;
use App\Models\TravelApplication;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ConcurrenceQueue extends Component
{
    use WithPagination;

    // Action modal
    public bool   $showActionModal   = false;
    public ?int   $actionAppId       = null;
    public string $action            = '';
    public string $comments          = '';

    // Filter
    public string $filterStatus = 'pending';

    protected $paginationTheme = 'bootstrap';

    public function openAction(int $appId, string $action): void
    {
        // Verify this user is the assigned concurrer
        $step = ConcurrenceStep::where('travel_application_id', $appId)
            ->where('approver_id', auth()->id())
            ->where('action', 'pending')
            ->first();

        if (! $step) {
            $this->dispatch('notify', type: 'error',
                message: 'You are not the assigned concurrer for this application.');
            return;
        }

        $this->actionAppId     = $appId;
        $this->action          = $action;
        $this->comments        = '';
        $this->showActionModal = true;
    }

    public function executeAction(): void
    {
        if (! $this->actionAppId || ! $this->action) return;

        // Comments required for return and not_concurred
        if (in_array($this->action, ['not_concurred', 'returned']) && empty(trim($this->comments))) {
            $this->dispatch('notify', type: 'error',
                message: 'Please provide comments explaining your decision.');
            return;
        }

        $step = ConcurrenceStep::where('travel_application_id', $this->actionAppId)
            ->where('approver_id', auth()->id())
            ->where('action', 'pending')
            ->first();

        if (! $step) {
            $this->dispatch('notify', type: 'error', message: 'Concurrence step not found.');
            return;
        }

        $app = TravelApplication::findOrFail($this->actionAppId);

        DB::transaction(function () use ($step, $app) {
            // Update concurrence step
            $step->update([
                'action'   => $this->action,
                'comments' => $this->comments ?: null,
                'acted_at' => now(),
            ]);

            // Update application status
            $newStatus = match($this->action) {
                'concurred'     => 'concurred',
                'not_concurred' => 'not_concurred',
                'returned'      => 'returned',
                default         => $app->status,
            };

            $app->update(['status' => $newStatus]);

            // Audit log
            $app->log($this->action, match($this->action) {
                'concurred'     => "Application concurred by {$step->approver->full_name}.",
                'not_concurred' => "Application not concurred by {$step->approver->full_name}. Reason: {$this->comments}",
                'returned'      => "Application returned by {$step->approver->full_name} for revision. Comments: {$this->comments}",
            });

            if ($this->action === 'concurred') {
                // Update days docket immediately on concurrence
                $this->updateDaysDocket($app);

                // Generate clearance letter automatically
                $this->generateClearanceLetter($app);

                // Notify applicant
                NotificationService::applicationConcurred($step);
            }

            if ($this->action === 'not_concurred') {
                NotificationService::applicationNotConcurred($step);
            }

            if ($this->action === 'returned') {
                NotificationService::applicationReturned($step);
            }

            // Send email notification to applicant
            $this->sendEmailNotification($app, $step);
        });

        $label = match($this->action) {
            'concurred'     => 'concurred ✓',
            'not_concurred' => 'not concurred',
            'returned'      => 'returned for revision',
        };

        $this->dispatch('notify', type: $this->action === 'concurred' ? 'success' : 'warning',
            message: "Application {$app->reference_number} has been {$label}.");

        $this->showActionModal = false;
        $this->actionAppId     = null;
        $this->action          = '';
        $this->comments        = '';
    }

    private function updateDaysDocket(TravelApplication $app): void
    {
        $days = $app->getDurationDays();
        $user = $app->user;

        // Reset docket if year has changed
        if ($user->docket_year !== now()->year) {
            $user->update([
                'days_used_this_year' => $days,
                'docket_year'         => now()->year,
            ]);
        } else {
            $user->increment('days_used_this_year', $days);
        }
    }

    private function generateClearanceLetter(TravelApplication $app): void
    {
        try {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.clearance-letter', [
                'app'  => $app,
                'user' => $app->user,
            ]);

            $filename = "clearance_{$app->reference_number}.pdf";
            $path     = "clearance/{$filename}";

            \Illuminate\Support\Facades\Storage::disk('local')->put($path, $pdf->output());

            $app->update([
                'clearance_letter_path'             => $path,
                'clearance_letter_generated_at'     => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Clearance letter generation failed for {$app->reference_number}: " . $e->getMessage());
        }
    }

    private function sendEmailNotification(TravelApplication $app, ConcurrenceStep $step): void
    {
        try {
            $subject = match($step->action) {
                'concurred'     => "Application Concurred — {$app->reference_number}",
                'not_concurred' => "Application Not Concurred — {$app->reference_number}",
                'returned'      => "Application Returned for Revision — {$app->reference_number}",
                default         => "Application Update — {$app->reference_number}",
            };

            \Illuminate\Support\Facades\Mail::html(
                view('emails.concurrence-decision', [
                    'app'       => $app,
                    'step'      => $step,
                    'applicant' => $app->user,
                ])->render(),
                fn($m) => $m->to($app->user->email)->subject($subject)
            );
        } catch (\Exception $e) {
            \Log::error("Concurrence email failed: " . $e->getMessage());
        }
    }

    public function render()
    {
        $user = auth()->user();

        // Applications where this user is the concurrer
        $queue = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
                $q->where('approver_id', $user->id)
                  ->when($this->filterStatus === 'pending', fn($q) => $q->where('action', 'pending'))
                  ->when($this->filterStatus === 'actioned', fn($q) => $q->where('action', '!=', 'pending'))
            )
            ->with([
                'user.role',
                'user.department',
                'country',
                'county',
                'concurrenceSteps' => fn($q) => $q->where('approver_id', $user->id),
            ])
            ->latest()
            ->paginate(10);

        $pendingCount = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
            $q->where('approver_id', $user->id)->where('action', 'pending')
        )->count();

        return view('livewire.travel.concurrence-queue',
            compact('queue', 'pendingCount'))
            ->layout('components.layouts.app');
    }
}
