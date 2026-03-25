<?php

namespace App\Livewire\Travel;

use App\Models\TravelApplication;
use App\Notifications\ApplicationClosed;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PostTripReview extends Component
{
    use WithPagination;

    public string $filterStatus = 'pending';

    protected $paginationTheme = 'bootstrap';

    public function closeApplication(int $appId): void
    {
        $app = TravelApplication::findOrFail($appId);

        // Verify this supervisor is the concurrer
        $isConcurrer = $app->concurrenceSteps()
            ->where('approver_id', auth()->id())
            ->where('action', 'concurred')
            ->exists();

        if (! $isConcurrer && ! auth()->user()->isSuperAdmin()) {
            $this->dispatch('notify', type: 'error',
                message: 'You are not authorised to close this application.');
            return;
        }

        if ($app->status !== 'pending_uploads') {
            $this->dispatch('notify', type: 'error',
                message: 'This application is not pending post-trip review.');
            return;
        }

        DB::transaction(function () use ($app) {
            $app->update(['status' => 'closed']);

            $app->log('closed',
                "Application reviewed and closed by " . auth()->user()->full_name . ".");

            // Notify applicant
            try {
                $app->user->notify(new ApplicationClosed($app));

                \Illuminate\Support\Facades\Mail::html(
                    view('emails.application-closed', [
                        'app'       => $app,
                        'applicant' => $app->user,
                        'closedBy'  => auth()->user(),
                    ])->render(),
                    fn($m) => $m->to($app->user->email)
                        ->subject("Application Closed — {$app->reference_number}")
                );
            } catch (\Exception $e) {
                \Log::error("Close notification failed: " . $e->getMessage());
            }
        });

        $this->dispatch('notify', type: 'success',
            message: "Application {$app->reference_number} closed successfully.");
    }

    public function render()
    {
        $user = auth()->user();

        // Applications this user concurred that now have post-trip uploads
        $apps = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
                $q->where('approver_id', $user->id)->where('action', 'concurred')
            )
            ->when($this->filterStatus === 'pending',
                fn($q) => $q->where('status', 'pending_uploads')
            )
            ->when($this->filterStatus === 'closed',
                fn($q) => $q->where('status', 'closed')
            )
            ->with(['user.role', 'country', 'county', 'postTripUpload',
                'documents' => fn($q) => $q->whereIn('document_type',
                    ['post_trip_report', 'post_trip_ticket', 'post_trip_passport'])])
            ->latest()
            ->paginate(10);

        $pendingCount = TravelApplication::whereHas('concurrenceSteps', fn($q) =>
            $q->where('approver_id', $user->id)->where('action', 'concurred')
        )->where('status', 'pending_uploads')->count();

        return view('livewire.travel.post-trip-review',
            compact('apps', 'pendingCount'))
            ->layout('components.layouts.app');
    }
}
