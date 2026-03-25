<?php

namespace App\Livewire\Travel;

use App\Models\ApplicationDocument;
use App\Models\PostTripUpload as PostTripUploadModel;
use App\Models\TravelApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostTripUpload extends Component
{
    use WithFileUploads;

    public ?int   $activeAppId    = null;
    public string $report_summary = '';
    public string $actual_cost    = '';
    public $doc_report   = null;
    public $doc_ticket   = null;
    public $doc_passport = null;

    protected $messages = [
        'report_summary.required' => 'Please provide a trip report summary.',
        'report_summary.min'      => 'Report summary must be at least 50 characters.',
        'doc_report.required'     => 'Post-trip report document is required.',
        'doc_report.mimetypes'    => 'Only PDF, JPG or PNG accepted.',
        'doc_report.max'          => 'File must not exceed 2MB.',
        'doc_ticket.mimetypes'    => 'Only PDF, JPG or PNG accepted.',
        'doc_ticket.max'          => 'File must not exceed 2MB.',
        'doc_passport.mimetypes'  => 'Only PDF, JPG or PNG accepted.',
        'doc_passport.max'        => 'File must not exceed 2MB.',
    ];

    public function mount(): void
    {
        $pending = $this->getPendingApplications();
        if ($pending->count() === 1) {
            $this->activeAppId = $pending->first()->id;
        }
    }

    private function getPendingApplications()
    {
        return TravelApplication::where('user_id', auth()->id())
            ->where('status', 'concurred')
            ->whereDate('return_date', '<=', now())
            ->whereDoesntHave('postTripUpload')
            ->with(['country', 'county'])
            ->latest()
            ->get();
    }

    protected function rules(): array
    {
        $fileRule = ['nullable', 'file',
            'mimetypes:application/pdf,image/jpeg,image/png,image/jpg',
            'max:2048'];

        return [
            'report_summary' => ['required', 'string', 'min:50', 'max:3000'],
            'actual_cost'    => ['nullable', 'numeric', 'min:0'],
            'doc_report'     => ['required', 'file',
                'mimetypes:application/pdf,image/jpeg,image/png,image/jpg', 'max:2048'],
            'doc_ticket'     => $fileRule,
            'doc_passport'   => $fileRule,
        ];
    }

    public function submit(): void
    {
        $this->validate();

        if (! $this->activeAppId) {
            $this->dispatch('notify', type: 'error', message: 'Please select an application.');
            return;
        }

        $app = TravelApplication::where('id', $this->activeAppId)
            ->where('user_id', auth()->id())
            ->where('status', 'concurred')
            ->firstOrFail();

        try {
            DB::transaction(function () use ($app) {
                $upload = PostTripUploadModel::create([
                    'travel_application_id' => $app->id,
                    'user_id'               => auth()->id(),
                    'report_summary'        => $this->report_summary,
                    'actual_cost'           => $this->actual_cost ?: null,
                    'submitted_at'          => now(),
                ]);

                $this->storePostTripDoc($app, 'doc_report',   'post_trip_report');
                $this->storePostTripDoc($app, 'doc_ticket',   'post_trip_ticket');
                $this->storePostTripDoc($app, 'doc_passport', 'post_trip_passport');

                $app->update(['status' => 'pending_uploads']);

                $app->log('post_trip_submitted',
                    "Post-trip documents submitted by {$app->user->full_name}.");

                // Notify supervisor
                $supervisor = $app->user->getConcurrer();
                if ($supervisor) {
                    $supervisor->notify(new \App\Notifications\PostTripSubmitted($app));

                    try {
                        \Illuminate\Support\Facades\Mail::html(
                            view('emails.post-trip-notification', [
                                'app'        => $app,
                                'applicant'  => $app->user,
                                'supervisor' => $supervisor,
                                'upload'     => $upload,
                            ])->render(),
                            fn($m) => $m->to($supervisor->email)
                                ->subject("Post-Trip Documents — {$app->reference_number} — {$app->user->full_name}")
                        );
                    } catch (\Exception $e) {
                        \Log::error("Post-trip email failed: " . $e->getMessage());
                    }
                }
            });

            session()->flash('notify_type', 'success');
            session()->flash('notify_message', 'Post-trip documents submitted. Your supervisor will review and close.');

            $this->redirect(route('travel.index'), navigate: false);

        } catch (\Exception $e) {
            \Log::error('Post-trip submit failed: ' . $e->getMessage());
            $this->dispatch('notify', type: 'error',
                message: 'Submission failed. Please try again.');
        }
    }

    private function storePostTripDoc(TravelApplication $app, string $property, string $type): void
    {
        if (! $this->$property) return;

        $file     = $this->$property;
        $ext      = strtolower($file->getClientOriginalExtension());
        $safeName = substr(strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '_',
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))), 0, 40);
        $filename = now()->format('Ymd_His') . "_{$type}_{$safeName}.{$ext}";
        $path     = $file->storeAs(
            "applications/{$app->reference_number}/post_trip",
            $filename, 'local'
        );

        $mimeType = $file->getMimeType() ?? match($ext) {
            'pdf'        => 'application/pdf',
            'jpg','jpeg' => 'image/jpeg',
            'png'        => 'image/png',
            default      => 'application/octet-stream',
        };

        try {
            $fileSize = Storage::disk('local')->size($path);
        } catch (\Exception $e) {
            $fileSize = null;
        }

        ApplicationDocument::create([
            'travel_application_id' => $app->id,
            'document_type'         => $type,
            'file_path'             => $path,
            'original_name'         => $file->getClientOriginalName(),
            'mime_type'             => $mimeType,
            'file_size'             => $fileSize,
            'uploaded_by'           => auth()->id(),
        ]);
    }

    public function render()
    {
        $pendingApps = $this->getPendingApplications();

        $submittedApps = TravelApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending_uploads', 'closed'])
            ->with(['country', 'county', 'postTripUpload'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.travel.post-trip-upload',
            compact('pendingApps', 'submittedApps'))
            ->layout('components.layouts.app');
    }
}
