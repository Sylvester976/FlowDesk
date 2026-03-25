<?php

namespace App\Livewire\Travel;

use App\Models\ApplicationDocument;
use App\Models\ConcurrenceStep;
use App\Models\Country;
use App\Models\County;
use App\Models\TravelApplication;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditApplication extends Component
{
    use WithFileUploads;

    public TravelApplication $application;

    // Editable fields
    public string $destination_details = '';
    public string $departure_date      = '';
    public string $return_date         = '';
    public string $funding_source      = '';
    public string $per_diem_days       = '';
    public string $purpose             = '';

    // New document uploads (optional replacements)
    public $doc_invitation  = null;
    public $doc_appointment = null;
    public $doc_passport    = null;
    public $doc_leave_form  = null;

    public bool $isNairobi = false;

    protected $messages = [
        'purpose.min'                   => 'Please provide at least 30 characters.',
        'departure_date.after_or_equal' => 'Departure date must be today or later.',
        'return_date.after_or_equal'    => 'Return date must be on or after departure date.',
        'doc_invitation.mimetypes'      => 'Only PDF, JPG or PNG accepted.',
        'doc_appointment.mimetypes'     => 'Only PDF, JPG or PNG accepted.',
        'doc_passport.mimetypes'        => 'Only PDF, JPG or PNG accepted.',
        'doc_leave_form.mimetypes'      => 'Only PDF, JPG or PNG accepted.',
        'doc_invitation.max'            => 'File must not exceed 2MB.',
        'doc_appointment.max'           => 'File must not exceed 2MB.',
        'doc_passport.max'              => 'File must not exceed 2MB.',
        'doc_leave_form.max'            => 'File must not exceed 2MB.',
    ];

    public function mount(TravelApplication $application): void
    {
        // Only the applicant can edit, and only if returned
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }
        if ($application->status !== 'returned') {
            abort(403, 'Only returned applications can be edited.');
        }

        $this->application        = $application;
        $this->destination_details= $application->destination_details ?? '';
        $this->departure_date     = $application->departure_date->format('Y-m-d');
        $this->return_date        = $application->return_date->format('Y-m-d');
        $this->funding_source     = $application->funding_source ?? '';
        $this->per_diem_days      = (string) ($application->per_diem_days ?? '');
        $this->purpose            = $application->purpose;

        if ($application->county_id) {
            $county = County::find($application->county_id);
            $this->isNairobi = $county && strtolower($county->name) === 'nairobi';
        }
    }

    public function updatedDepartureDate(): void { $this->autoPerDiem(); }
    public function updatedReturnDate(): void    { $this->autoPerDiem(); }

    private function autoPerDiem(): void
    {
        if ($this->departure_date && $this->return_date && ! $this->isNairobi) {
            try {
                $days = \Carbon\Carbon::parse($this->departure_date)
                    ->diffInDays(\Carbon\Carbon::parse($this->return_date));
                $this->per_diem_days = (string) max(0, $days);
            } catch (\Exception $e) {}
        }
    }

    protected function rules(): array
    {
        $fileRule = ['nullable', 'file',
            'mimetypes:application/pdf,image/jpeg,image/png,image/jpg',
            'max:2048'];

        return [
            'departure_date'     => ['required', 'date', 'after_or_equal:today'],
            'return_date'        => ['required', 'date', 'after_or_equal:departure_date'],
            'purpose'            => ['required', 'string', 'min:30', 'max:2000'],
            'destination_details'=> ['nullable', 'string', 'max:200'],
            'funding_source'     => $this->application->isForeignOfficial()
                ? ['required', 'string', 'max:200'] : ['nullable'],
            'per_diem_days'      => (! $this->isNairobi && ! $this->application->isForeignPrivate())
                ? ['required', 'integer', 'min:0', 'max:365'] : ['nullable'],
            'doc_invitation'     => $fileRule,
            'doc_appointment'    => $fileRule,
            'doc_passport'       => $fileRule,
            'doc_leave_form'     => $fileRule,
        ];
    }

    public function resubmit(): void
    {
        $this->validate();

        DB::transaction(function () {
            $app = $this->application;

            // Update application
            $app->update([
                'destination_details' => $this->destination_details ?: null,
                'departure_date'      => $this->departure_date,
                'return_date'         => $this->return_date,
                'funding_source'      => $this->funding_source ?: null,
                'per_diem_days'       => ($this->per_diem_days !== '' && ! $this->isNairobi)
                    ? (int) $this->per_diem_days : null,
                'purpose'             => $this->purpose,
                'status'              => 'pending_concurrence',
            ]);

            // Replace documents if new ones uploaded
            $this->replaceDocument($app, 'doc_invitation',  'invitation_letter');
            $this->replaceDocument($app, 'doc_appointment', 'appointment_letter');
            $this->replaceDocument($app, 'doc_passport',    'passport_copy');
            $this->replaceDocument($app, 'doc_leave_form',  'leave_form');

            // Reset concurrence step to pending
            ConcurrenceStep::where('travel_application_id', $app->id)
                ->update([
                    'action'   => 'pending',
                    'comments' => null,
                    'acted_at' => null,
                ]);

            // Audit log
            $app->log('resubmitted', "Application resubmitted by {$app->user->full_name} after revision.");

            // Re-notify supervisor
            NotificationService::applicationSubmitted($app);

            // Email supervisor
            $concurrer = $app->user->getConcurrer();
            if ($concurrer) {
                try {
                    \Illuminate\Support\Facades\Mail::html(
                        view('emails.travel-notification', [
                            'app'         => $app,
                            'applicant'   => $app->user,
                            'recipient'   => $concurrer,
                            'isConcurrer' => true,
                        ])->render(),
                        fn($m) => $m->to($concurrer->email)
                            ->subject("Resubmitted: Travel Application — {$app->reference_number}")
                    );
                } catch (\Exception $e) {
                    \Log::error("Resubmit email failed: " . $e->getMessage());
                }
            }
        });

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Application resubmitted successfully. Your supervisor has been notified.');

        $this->redirect(route('travel.show', $this->application->id), navigate: false);
    }

    private function replaceDocument(TravelApplication $app, string $property, string $type): void
    {
        if (! $this->$property) return;

        // Delete old document of same type
        $old = $app->documents()->where('document_type', $type)->first();
        if ($old) {
            Storage::disk('local')->delete($old->file_path);
            $old->delete();
        }

        $file     = $this->$property;
        $ext      = strtolower($file->getClientOriginalExtension());
        $safeName = substr(strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '_',
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))), 0, 40);
        $filename = now()->format('Ymd_His') . "_{$type}_{$safeName}.{$ext}";

        $path = $file->storeAs("applications/{$app->reference_number}", $filename, 'local');

        $mimeType = $file->getMimeType() ?? match($ext) {
            'pdf'         => 'application/pdf',
            'jpg','jpeg'  => 'image/jpeg',
            'png'         => 'image/png',
            default       => 'application/octet-stream',
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
        $countries = Country::where('name', '!=', 'Kenya')->orderBy('name')->get(['id', 'name']);
        $counties  = County::orderBy('name')->get(['id', 'name']);

        return view('livewire.travel.edit-application', compact('countries', 'counties'))
            ->layout('components.layouts.app');
    }
}
