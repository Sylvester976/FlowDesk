<?php

namespace App\Livewire\Travel;

use App\Models\ApplicationDocument;
use App\Models\ConcurrenceStep;
use App\Models\Country;
use App\Models\County;
use App\Models\TravelApplication;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TravelWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Step 1 — Type
    public string $travel_type = '';

    // Step 2 — Trip details
    public string $country_id          = '';
    public string $county_id           = '';
    public string $destination_details = '';
    public string $departure_date      = '';
    public string $return_date         = '';
    public string $funding_source      = '';
    public string $per_diem_days       = '';
    public string $purpose             = '';

    // Step 3 — Leave gate (foreign private only)
    public ?bool $leave_approved = null;

    // Step 3 — Documents
    public $doc_invitation  = null;
    public $doc_appointment = null;
    public $doc_passport    = null;
    public $doc_leave_form  = null;

    // Computed
    public bool $isNairobi = false;

    // Confirm submit modal
    public bool $showSubmitConfirm = false;

    // ── Validation messages ───────────────────────────────────

    protected $messages = [
        'doc_invitation.required'       => 'Invitation / request letter is required.',
        'doc_appointment.required'      => 'Appointment letter is required.',
        'doc_passport.required'         => 'Passport copy is required.',
        'doc_leave_form.required'       => 'Leave form is required.',
        'doc_invitation.mimetypes'      => 'Only PDF, JPG or PNG files accepted.',
        'doc_appointment.mimetypes'     => 'Only PDF, JPG or PNG files accepted.',
        'doc_passport.mimetypes'        => 'Only PDF, JPG or PNG files accepted.',
        'doc_leave_form.mimetypes'      => 'Only PDF, JPG or PNG files accepted.',
        'doc_invitation.max'            => 'File must not exceed 2MB.',
        'doc_appointment.max'           => 'File must not exceed 2MB.',
        'doc_passport.max'              => 'File must not exceed 2MB.',
        'doc_leave_form.max'            => 'File must not exceed 2MB.',
        'purpose.min'                   => 'Please provide at least 30 characters describing the purpose.',
        'purpose.required'              => 'Purpose is required.',
        'country_id.required'           => 'Please select a destination country.',
        'county_id.required'            => 'Please select a destination county.',
        'funding_source.required'       => 'Please specify the funding source.',
        'per_diem_days.required'        => 'Please enter the number of per diem days.',
        'departure_date.required'       => 'Departure date is required.',
        'departure_date.after_or_equal' => 'Departure date must be today or later.',
        'return_date.required'          => 'Return date is required.',
        'return_date.after_or_equal'    => 'Return date must be on or after departure date.',
    ];

    // ── Watchers ──────────────────────────────────────────────

    public function updatedCountyId(string $val): void
    {
        $county          = County::find($val);
        $this->isNairobi = $county && strtolower($county->name) === 'nairobi';
        if ($this->isNairobi) $this->per_diem_days = '';
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

    // ── Step navigation ───────────────────────────────────────

    public function nextStep(): void
    {
        try {
            match($this->step) {
                1 => $this->validateStep1(),
                2 => $this->validateStep2(),
                3 => $this->validateStep3(),
                default => null,
            };
        } catch (\Illuminate\Validation\ValidationException $e) {
            $first = collect($e->errors())->flatten()->first();
            $this->dispatch('notify', type: 'error', message: $first);
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) $this->step--;
    }

    private function validateStep1(): void
    {
        $this->validate(
            ['travel_type' => ['required', 'in:foreign_official,foreign_private,local']],
            ['travel_type.required' => 'Please select a travel type.']
        );

        // Active application gate — one at a time
        $activeApp = auth()->user()->travelApplications()
            ->whereIn('status', ['submitted', 'pending_concurrence', 'returned', 'pending_uploads'])
            ->first();

        if ($activeApp) {
            $this->dispatch('notify', type: 'error',
                message: "You already have an active application ({$activeApp->reference_number} — {$activeApp->getStatusLabel()}). Complete or resolve it before applying for new travel.");
            return;
        }

        // Post-trip gate (catches closed trips with pending uploads)
        if (auth()->user()->hasPendingPostTripUploads()) {
            $this->dispatch('notify', type: 'error',
                message: 'You have pending post-trip uploads. Complete them before applying for new travel.');
            return;
        }

        if ($this->travel_type === 'foreign_official') {
            $user = auth()->user();
            if ($user->days_remaining <= 0) {
                $this->dispatch('notify', type: 'error',
                    message: "You have exhausted your {$user->max_days_per_year} foreign travel days for this year. Contact HR.");
                return;
            }
        }

        $this->step = 2;
    }

    private function validateStep2(): void
    {
        $rules = [
            'departure_date' => ['required', 'date', 'after_or_equal:today'],
            'return_date'    => ['required', 'date', 'after_or_equal:departure_date'],
            'purpose'        => ['required', 'string', 'min:30', 'max:2000'],
        ];

        if (in_array($this->travel_type, ['foreign_official', 'foreign_private'])) {
            $rules['country_id']          = ['required', 'exists:countries,id'];
            $rules['destination_details'] = ['nullable', 'string', 'max:200'];
        }

        if ($this->travel_type === 'local') {
            $rules['county_id'] = ['required', 'exists:counties,id'];
        }

        if ($this->travel_type === 'foreign_official') {
            $rules['funding_source'] = ['required', 'string', 'max:200'];
        }

        if (! $this->isNairobi && $this->travel_type !== 'foreign_private') {
            $rules['per_diem_days'] = ['required', 'integer', 'min:0', 'max:365'];
        }

        $this->validate($rules);

        $this->step = 3;
    }

    private function validateStep3(): void
    {
        // Foreign private: leave gate
        if ($this->travel_type === 'foreign_private') {
            if ($this->leave_approved === null) {
                $this->dispatch('notify', type: 'warning',
                    message: 'Please confirm whether your leave has been approved.');
                return;
            }
            if ((string) $this->leave_approved === '0' || $this->leave_approved === false) {
                $this->dispatch('notify', type: 'error',
                    message: 'You must have approved leave before applying for foreign private travel. Please apply for leave first.');
                return;
            }
        }

        $fileRule = ['required', 'file',
            'mimetypes:application/pdf,image/jpeg,image/png,image/jpg',
            'max:2048'];

        $rules = match($this->travel_type) {
            'foreign_official' => [
                'doc_invitation'  => $fileRule,
                'doc_appointment' => $fileRule,
                'doc_passport'    => $fileRule,
            ],
            'foreign_private' => [
                'doc_passport'   => $fileRule,
                'doc_leave_form' => $fileRule,
            ],
            'local' => [
                'doc_appointment' => $fileRule,
            ],
            default => [],
        };

        if (! empty($rules)) {
            $this->validate($rules);
        }

        $this->step = 4;
    }

    // ── Confirm + Submit ──────────────────────────────────────

    public function confirmSubmit(): void
    {
        $this->showSubmitConfirm = true;
    }

    public function submit(): void
    {
        $user = auth()->user();

        try {
            DB::transaction(function () use ($user) {
                $app = TravelApplication::create([
                    'user_id'             => $user->id,
                    'travel_type'         => $this->travel_type,
                    'country_id'          => $this->country_id ?: null,
                    'county_id'           => $this->county_id ?: null,
                    'destination_details' => $this->destination_details ?: null,
                    'departure_date'      => $this->departure_date,
                    'return_date'         => $this->return_date,
                    'funding_source'      => $this->funding_source ?: null,
                    'per_diem_days'       => ($this->per_diem_days !== '' && ! $this->isNairobi)
                        ? (int) $this->per_diem_days : null,
                    'purpose'             => $this->purpose,
                    'leave_approved'      => $this->travel_type === 'foreign_private'
                        ? (bool) $this->leave_approved : null,
                    'status'              => $this->travel_type === 'foreign_official'
                        ? 'pending_concurrence' : 'submitted',
                    'reference_number'    => TravelApplication::generateReference($this->travel_type),
                ]);

                // Store documents using 'local' disk (always configured)
                $this->storeDocument($app, 'doc_invitation',  'invitation_letter');
                $this->storeDocument($app, 'doc_appointment', 'appointment_letter');
                $this->storeDocument($app, 'doc_passport',    'passport_copy');
                $this->storeDocument($app, 'doc_leave_form',  'leave_form');

                // Audit log
                $app->log('submitted', "Application submitted by {$user->full_name}.", [
                    'travel_type' => $this->travel_type,
                    'reference'   => $app->reference_number,
                ]);

                // Foreign official — create concurrence step
                if ($this->travel_type === 'foreign_official') {
                    $concurrer = $user->getConcurrer();
                    if ($concurrer) {
                        ConcurrenceStep::create([
                            'travel_application_id' => $app->id,
                            'approver_id'           => $concurrer->id,
                            'action'                => 'pending',
                        ]);
                    }
                }

                // Send notifications — email + in-app
                $this->sendNotifications($app, $user);
                \App\Services\NotificationService::applicationSubmitted($app);
            });

            session()->flash('notify_type', 'success');
            session()->flash('notify_message', 'Application submitted successfully.');

            $this->redirect(route('travel.index'), navigate: false);

        } catch (\Exception $e) {
            \Log::error('Travel submit failed: ' . $e->getMessage());
            $this->dispatch('notify', type: 'error',
                message: 'Submission failed. Please try again or contact support.');
        }
    }

    private function storeDocument(TravelApplication $app, string $property, string $type): void
    {
        if (! $this->$property) return;

        $file         = $this->$property;
        $ext          = strtolower($file->getClientOriginalExtension());
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Sanitise original name — lowercase, spaces to underscores, strip special chars
        $safeName = strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '_', $originalName));
        $safeName = preg_replace('/_+/', '_', trim($safeName, '_'));
        $safeName = substr($safeName, 0, 40); // cap length

        // Structured filename: YYYYMMDD_HHMMSS_{doc_type}_{original_name}.{ext}
        $filename = now()->format('Ymd_His') . "_{$type}_{$safeName}.{$ext}";

        $path = $file->storeAs(
            "applications/{$app->reference_number}",
            $filename,
            'local'
        );

        // Get file size safely — read from storage after saving
        try {
            $fileSize = \Illuminate\Support\Facades\Storage::disk('local')->size($path);
        } catch (\Exception $e) {
            $fileSize = null;
        }

        // getMimeType() can return null on Livewire temp files — derive from extension as fallback
        $mimeType = $file->getMimeType() ?? match($ext) {
            'pdf'         => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            default       => 'application/octet-stream',
        };

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

    private function sendNotifications(TravelApplication $app, $user): void
    {
        foreach ($user->getNotifyList() as $recipient) {
            try {
                \Illuminate\Support\Facades\Mail::html(
                    view('emails.travel-notification', [
                        'app'         => $app,
                        'applicant'   => $user,
                        'recipient'   => $recipient,
                        'isConcurrer' => $app->isForeignOfficial() &&
                            $user->getConcurrer()?->id === $recipient->id,
                    ])->render(),
                    fn($m) => $m->to($recipient->email)
                        ->subject("Travel Application — {$app->reference_number} — {$user->full_name}")
                );
            } catch (\Exception $e) {
                \Log::error("Notification failed to {$recipient->email}: " . $e->getMessage());
            }
        }
    }

    public function render()
    {
        $countries = Country::where('name', '!=', 'Kenya')
            ->orderBy('name')
            ->get(['id', 'name']);

        $counties = County::orderBy('name')->get(['id', 'name']);

        $user = auth()->user();

        return view('livewire.travel.travel-wizard', compact('countries', 'counties', 'user'))
            ->layout('components.layouts.app');
    }
}
