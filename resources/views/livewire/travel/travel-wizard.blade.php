@php use Carbon\Carbon; @endphp
<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">New Travel Application</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <a href="{{ route('travel.index') }}" class="breadcrumb-item">My Applications</a>
                    <span class="breadcrumb-item active">New Application</span>
                </nav>
            </div>
        </div>

        {{-- ── Progress Steps ───────────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center justify-content-between position-relative">

                    {{-- Background track --}}
                    <div style="position:absolute;top:18px;left:calc(12.5% + 18px);right:calc(12.5% + 18px);
                    height:2px;background:var(--bs-border-color);z-index:0;"></div>

                    {{-- Progress fill — 0%, 33%, 66%, 100% for steps 1-4 --}}
                    @php $pct = [1=>0, 2=>33, 3=>66, 4=>100][$step] ?? 0; @endphp
                    <div style="position:absolute;top:18px;left:calc(12.5% + 18px);
                    height:2px;background:#1a3a6b;z-index:1;
                    width:{{ $pct }}%;max-width:calc(100% - 25% - 36px);
                    transition:width .4s ease;"></div>

                    @foreach([1 => 'Travel Type', 2 => 'Trip Details', 3 => 'Documents', 4 => 'Review'] as $s => $label)
                        <div class="d-flex flex-column align-items-center" style="z-index:2;flex:1;">
                            <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;
                        justify-content:center;font-size:.82rem;font-weight:600;border:2px solid;
                        transition:all .3s;
                        background:{{ $step > $s ? '#1a3a6b' : '#fff' }};
                        color:{{ $step > $s ? '#fff' : ($step === $s ? '#1a3a6b' : '#adb5bd') }};
                        border-color:{{ $step >= $s ? '#1a3a6b' : '#dee2e6' }};">
                                @if($step > $s)
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    {{ $s }}
                                @endif
                            </div>
                            <span class="mt-1 d-none d-sm-block text-center"
                                  style="font-size:.72rem;
                        color:{{ $step === $s ? '#1a3a6b' : 'var(--bs-secondary-color)' }};
                        font-weight:{{ $step === $s ? '600' : '400' }};">
                        {{ $label }}
                    </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Step 1: Travel Type ──────────────────────────────── --}}
        @if($step === 1)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>Select Travel Type
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'foreign_official')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid {{ $travel_type === 'foreign_official' ? '#1a3a6b' : 'var(--bs-border-color)' }};
                            background:{{ $travel_type === 'foreign_official' ? '#e8f0fb' : 'transparent' }};
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#1a3a6b;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-briefcase text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#1a3a6b;">Foreign Official</span>
                                    @if($travel_type === 'foreign_official')
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#1a3a6b;"></i>
                                    @endif
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Official government travel abroad. Requires supervisor concurrence
                                    and counts against your annual travel days.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'foreign_private')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid {{ $travel_type === 'foreign_private' ? '#006b3f' : 'var(--bs-border-color)' }};
                            background:{{ $travel_type === 'foreign_private' ? '#e8f5ee' : 'transparent' }};
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#006b3f;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-person text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#006b3f;">Foreign Private</span>
                                    @if($travel_type === 'foreign_private')
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#006b3f;"></i>
                                    @endif
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Personal travel abroad during approved leave.
                                    PS is notified. Does not affect your travel days.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div wire:click="$set('travel_type', 'local')"
                                 class="p-4 rounded h-100 d-flex flex-column"
                                 style="cursor:pointer;border:2px solid {{ $travel_type === 'local' ? '#c8a951' : 'var(--bs-border-color)' }};
                            background:{{ $travel_type === 'local' ? '#fff8e1' : 'transparent' }};
                            transition:all .2s;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#c8a951;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-geo-alt text-white" style="font-size:.9rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="color:#78620a;">Local</span>
                                    @if($travel_type === 'local')
                                        <i class="bi bi-check-circle-fill ms-auto" style="color:#c8a951;"></i>
                                    @endif
                                </div>
                                <p class="text-muted mb-0" style="font-size:.82rem;line-height:1.6;">
                                    Travel within Kenya. Supervisor is notified.
                                    No per diem for travel within Nairobi County.
                                </p>
                            </div>
                        </div>

                    </div>

                    {{-- Days docket info (foreign official) --}}
                    @if($travel_type === 'foreign_official')
                        <div class="mt-3 p-3 rounded d-flex justify-content-between align-items-center flex-wrap gap-2"
                             style="background:#e8f5ee;border-left:4px solid #006b3f;">
                <span style="font-size:.83rem;color:#085041;">
                    <i class="bi bi-calendar-check me-1"></i>
                    Your foreign travel days this year:
                </span>
                            <span class="fw-semibold" style="color:#085041;">
                    {{ $user->days_used_this_year }} used /
                    {{ $user->max_days_per_year }} allowed
                    &mdash; <strong>{{ $user->days_remaining }} remaining</strong>
                </span>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button wire:click="nextStep" class="btn btn-primary"
                            @if(!$travel_type) disabled @endif>
                        Next <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ── Step 2: Trip Details ─────────────────────────────── --}}
        @if($step === 2)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-map me-2" style="color:#1a3a6b;"></i>Trip Details
                        <span class="badge ms-2" style="font-size:.72rem;color:#fff;
                    background:{{ $travel_type === 'foreign_official' ? '#1a3a6b' : ($travel_type === 'foreign_private' ? '#006b3f' : '#c8a951') }};">
                    {{ $travel_type === 'foreign_official' ? 'Foreign Official' : ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local') }}
                </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- Foreign: Country --}}
                        @if(in_array($travel_type, ['foreign_official', 'foreign_private']))
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Destination Country <span
                                        class="text-danger">*</span></label>
                                <select wire:model="country_id"
                                        class="form-select @error('country_id') is-invalid @enderror">
                                    <option value="">Select country...</option>
                                    @foreach($countries as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">City / Specific Location</label>
                                <input type="text" wire:model="destination_details"
                                       class="form-control" placeholder="e.g. Nairobi, Westlands">
                            </div>
                        @endif

                        {{-- Local: County --}}
                        @if($travel_type === 'local')
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Destination County <span
                                        class="text-danger">*</span></label>
                                <select wire:model.live="county_id"
                                        class="form-select @error('county_id') is-invalid @enderror">
                                    <option value="">Select county...</option>
                                    @foreach($counties as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                @error('county_id')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Specific Location</label>
                                <input type="text" wire:model="destination_details"
                                       class="form-control" placeholder="e.g. Nakuru Town, KICC">
                            </div>
                        @endif

                        {{-- Dates --}}
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Departure Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" wire:model.live="departure_date"
                                   class="form-control @error('departure_date') is-invalid @enderror"
                                   min="{{ now()->format('Y-m-d') }}">
                            @error('departure_date')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Return Date <span class="text-danger">*</span></label>
                            <input type="date" wire:model.live="return_date"
                                   class="form-control @error('return_date') is-invalid @enderror"
                                   min="{{ $departure_date ?: now()->format('Y-m-d') }}">
                            @error('return_date')
                            <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Per diem --}}
                        @if($travel_type !== 'foreign_private')
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">
                                    Per Diem Days @if(!$isNairobi)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="number" wire:model="per_diem_days"
                                       class="form-control @error('per_diem_days') is-invalid @enderror"
                                       min="0" max="365"
                                       @if($isNairobi) disabled placeholder="Not applicable for Nairobi" @endif>
                                @error('per_diem_days')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">
                                    @if($isNairobi)
                                        <span class="text-warning"><i class="bi bi-info-circle me-1"></i>No per diem for Nairobi County.</span>
                                    @else
                                        Auto-calculated from dates. You can adjust.
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Funding source --}}
                        @if($travel_type === 'foreign_official')
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Funding Source <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="funding_source"
                                       class="form-control @error('funding_source') is-invalid @enderror"
                                       placeholder="e.g. GoK, World Bank, AfDB, Self-funded">
                                @error('funding_source')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        @endif

                        {{-- Purpose --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Purpose &amp; Activity Description <span class="text-danger">*</span>
                            </label>
                            <textarea wire:model="purpose" rows="4"
                                      class="form-control @error('purpose') is-invalid @enderror"
                                      placeholder="Describe what you will be doing, which meetings or activities you will attend, and the expected outcomes..."></textarea>
                            @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="form-text">
                                    {{ strlen($purpose) }} characters &mdash; minimum 30 required.
                                </div>
                                @enderror
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button wire:click="nextStep" class="btn btn-primary">
                        Next <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ── Step 3: Leave gate + Documents ──────────────────── --}}
        @if($step === 3)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>
                        @if($travel_type === 'foreign_private')
                            Leave &amp;
                        @endif Documents
                    </h5>
                </div>
                <div class="card-body">

                    {{-- Leave gate --}}
                    @if($travel_type === 'foreign_private')
                        <div class="p-4 rounded mb-4" style="background:#fff8e1;border:1px solid #f0c040;">
                            <h6 class="fw-semibold mb-2" style="color:#78620a;">
                                <i class="bi bi-calendar-check me-2"></i>Leave Confirmation Required
                            </h6>
                            <p style="font-size:.84rem;color:#78620a;margin-bottom:1rem;">
                                Foreign private travel requires approved annual leave. Has your leave been approved by
                                HR?
                            </p>
                            <div class="d-flex flex-wrap gap-3">
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="radio" wire:model.live="leave_approved" value="1"
                                           class="form-check-input mt-0">
                                    <span class="fw-medium" style="color:#006b3f;">
                            <i class="bi bi-check-circle me-1"></i>Yes, my leave is approved
                        </span>
                                </label>
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="radio" wire:model.live="leave_approved" value="0"
                                           class="form-check-input mt-0">
                                    <span class="fw-medium" style="color:#bb0000;">
                            <i class="bi bi-x-circle me-1"></i>No, I haven't applied yet
                        </span>
                                </label>
                            </div>

                            @if((string)$leave_approved === '0')
                                <div class="mt-3 p-3 rounded" style="background:#ffebee;border-left:4px solid #bb0000;">
                                    <p class="mb-0 fw-medium" style="color:#bb0000;font-size:.84rem;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        You cannot proceed without approved leave.
                                        Please apply for annual leave through HR first, then return here.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Documents --}}
                    @if($travel_type !== 'foreign_private' || (string)$leave_approved === '1')
                        <div class="row g-3">

                            @if($travel_type === 'foreign_official')
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Invitation / Request Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_invitation"
                                           class="form-control @error('doc_invitation') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_invitation')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Appointment Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_appointment"
                                           class="form-control @error('doc_appointment') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_appointment')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Passport Copy <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_passport"
                                           class="form-control @error('doc_passport') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_passport')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">Bio-data page &mdash; PDF or image (JPG/PNG) &mdash; max
                                        2MB
                                    </div>
                                </div>
                            @endif

                            @if($travel_type === 'foreign_private')
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Passport Copy <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_passport"
                                           class="form-control @error('doc_passport') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_passport')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Approved Leave Form <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_leave_form"
                                           class="form-control @error('doc_leave_form') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_leave_form')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                            @endif

                            @if($travel_type === 'local')
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">
                                        Appointment Letter <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" wire:model="doc_appointment"
                                           class="form-control @error('doc_appointment') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png,.PDF,.JPG,.JPEG,.PNG">
                                    @error('doc_appointment')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">PDF or image (JPG/PNG) &mdash; max 2MB</div>
                                </div>
                            @endif

                        </div>

                        {{-- Upload spinner --}}
                        <div wire:loading wire:target="doc_invitation,doc_appointment,doc_passport,doc_leave_form"
                             class="mt-3 d-flex align-items-center gap-2 text-muted" style="font-size:.83rem;">
                            <span class="spinner-border spinner-border-sm"></span> Uploading...
                        </div>
                    @endif

                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    @if($travel_type !== 'foreign_private' || (string)$leave_approved === '1')
                        <button wire:click="nextStep" class="btn btn-primary">
                            Next <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- ── Step 4: Review & Submit ──────────────────────────── --}}
        @if($step === 4)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-check-circle me-2" style="color:#006b3f;"></i>Review &amp; Submit
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);">
                                <h6 class="fw-semibold mb-3" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Trip Summary</h6>
                                <table style="width:100%;font-size:.85rem;">
                                    <tr>
                                        <td class="text-muted pb-2" style="width:42%;">Type</td>
                                        <td class="fw-medium pb-2">
                                            {{ $travel_type === 'foreign_official' ? 'Foreign Official' :
                                               ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pb-2">Destination</td>
                                        <td class="fw-medium pb-2">
                                            @if($country_id)
                                                {{ $countries->firstWhere('id', $country_id)?->name }}
                                            @elseif($county_id)
                                                {{ $counties->firstWhere('id', $county_id)?->name }} County
                                                @endif
                                                @if($destination_details) &mdash; {{ $destination_details }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pb-2">Dates</td>
                                        <td class="fw-medium pb-2">
                                            {{ Carbon::parse($departure_date)->format('d M Y') }}
                                            &rarr; {{ Carbon::parse($return_date)->format('d M Y') }}
                                        </td>
                                    </tr>
                                    @if($per_diem_days && !$isNairobi && $travel_type !== 'foreign_private')
                                        <tr>
                                            <td class="text-muted pb-2">Per Diem Days</td>
                                            <td class="fw-medium pb-2">{{ $per_diem_days }} day(s)</td>
                                        </tr>
                                    @endif
                                    @if($funding_source)
                                        <tr>
                                            <td class="text-muted pb-2">Funding</td>
                                            <td class="fw-medium pb-2">{{ $funding_source }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);height:100%;">
                                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Purpose</h6>
                                <p style="font-size:.85rem;line-height:1.7;margin:0;">{{ $purpose }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);">
                                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;
                            letter-spacing:.05em;color:var(--bs-secondary-color);">Documents Attached</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if($doc_invitation)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Invitation Letter ✓
                                </span>
                                    @endif
                                    @if($doc_appointment)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Appointment Letter ✓
                                </span>
                                    @endif
                                    @if($doc_passport)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Passport Copy ✓
                                </span>
                                    @endif
                                    @if($doc_leave_form)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-file-earmark-check me-1"></i>Leave Form ✓
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded" style="background:#e8f0fb;border-left:4px solid #1a3a6b;">
                                <h6 class="fw-semibold mb-1" style="color:#1a3a6b;font-size:.84rem;">
                                    What happens next?
                                </h6>
                                <p class="mb-0" style="font-size:.82rem;color:#374151;line-height:1.7;">
                                    @if($travel_type === 'foreign_official')
                                        Your application goes to your supervisor for concurrence.
                                        A clearance letter is generated automatically once concurred.
                                        Your travel days are updated on concurrence.
                                    @elseif($travel_type === 'foreign_private')
                                        The Principal Secretary is notified for record purposes.
                                        No concurrence required. Travel days are not affected.
                                    @else
                                        Your supervisor is notified of your local travel.
                                        No concurrence required.
                                    @endif
                                    After returning, you must upload post-trip documents before your next application.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button wire:click="prevStep" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <button wire:click="confirmSubmit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-1"></i> Submit Application
                    </button>
                </div>
            </div>
        @endif

        {{-- ── Confirm submit modal ────────────────────────────── --}}
        @if($showSubmitConfirm)
            <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title">
                                <i class="bi bi-send me-2" style="color:#1a3a6b;"></i>Confirm Submission
                            </h5>
                            <button wire:click="$set('showSubmitConfirm', false)" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3" style="font-size:.88rem;">
                                You are about to submit a
                                <strong>
                                    {{ $travel_type === 'foreign_official' ? 'Foreign Official' :
                                       ($travel_type === 'foreign_private' ? 'Foreign Private' : 'Local') }}
                                </strong>
                                travel application.
                            </p>
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);font-size:.84rem;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Destination</span>
                                    <span class="fw-medium">
                                @if($country_id)
                                            {{ $countries->firstWhere('id', $country_id)?->name }}
                                        @elseif($county_id)
                                            {{ $counties->firstWhere('id', $county_id)?->name }} County
                                        @endif
                            </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Dates</span>
                                    <span class="fw-medium">
                                {{ Carbon::parse($departure_date)->format('d M Y') }}
                                &rarr; {{ Carbon::parse($return_date)->format('d M Y') }}
                            </span>
                                </div>
                            </div>
                            @if($travel_type === 'foreign_official')
                                <div class="mt-3 p-2 rounded d-flex align-items-start gap-2"
                                     style="background:#fff8e1;border-left:3px solid #c8a951;font-size:.82rem;color:#78620a;">
                                    <i class="bi bi-exclamation-triangle mt-1 flex-shrink-0"></i>
                                    <span>This will be sent to your supervisor for concurrence and
                        will count against your annual travel days once concurred.</span>
                                </div>
                            @endif
                            <p class="mt-3 mb-0 text-muted" style="font-size:.82rem;">
                                Once submitted, you cannot edit this application. Are you sure?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button wire:click="$set('showSubmitConfirm', false)"
                                    class="btn btn-outline-secondary btn-sm">
                                Go Back &amp; Review
                            </button>
                            <button wire:click="submit" class="btn btn-primary btn-sm px-4"
                                    wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-send me-1"></i> Yes, Submit
                        </span>
                                <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>Submitting...
                        </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
