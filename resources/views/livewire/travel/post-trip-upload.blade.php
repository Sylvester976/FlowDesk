<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">Post-Trip Upload</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <a href="{{ route('travel.index') }}" class="breadcrumb-item">My Applications</a>
                    <span class="breadcrumb-item active">Post-Trip Upload</span>
                </nav>
            </div>
        </div>

        {{-- No pending apps --}}
        @if($pendingApps->isEmpty() && $submittedApps->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-check-circle fs-2 d-block mb-2 text-success"></i>
                    No post-trip uploads required at this time.
                    <a href="{{ route('travel.index') }}" class="d-block mt-2">Back to applications</a>
                </div>
            </div>
        @endif

        {{-- Pending uploads --}}
        @if($pendingApps->count())
            <form wire:submit="submit" novalidate>
                <div class="row g-3">
                    <div class="col-12 col-lg-8">

                        {{-- Select application if multiple --}}
                        @if($pendingApps->count() > 1)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>
                                        Select Application
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @foreach($pendingApps as $pApp)
                                        <label class="d-flex align-items-center gap-3 p-3 rounded border mb-2"
                                               style="cursor:pointer;{{ $activeAppId == $pApp->id ? 'background:#e8f0fb;border-color:#1a3a6b !important;' : '' }}">
                                            <input type="radio" wire:model.live="activeAppId"
                                                   value="{{ $pApp->id }}" class="form-check-input mt-0">
                                            <div>
                                                <div class="fw-medium" style="font-size:.88rem;">
                                                    {{ $pApp->reference_number }}
                                                </div>
                                                <div class="text-muted" style="font-size:.78rem;">
                                                    {{ $pApp->country?->name ?? ($pApp->county?->name . ' County') }}
                                                    &mdash;
                                                    {{ $pApp->departure_date->format('d M') }} →
                                                    {{ $pApp->return_date->format('d M Y') }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Single app — show info banner --}}
                            @php $singleApp = $pendingApps->first(); @endphp
                            <div class="card mb-3 border-0" style="background:#e8f0fb;">
                                <div class="card-body py-2 d-flex align-items-center gap-3 flex-wrap">
                                    <div>
                            <span class="fw-semibold" style="color:#1a3a6b;">
                                {{ $singleApp->reference_number }}
                            </span>
                                        <span class="text-muted ms-2" style="font-size:.82rem;">
                                {{ $singleApp->country?->name ?? ($singleApp->county?->name . ' County') }}
                                &mdash;
                                {{ $singleApp->departure_date->format('d M') }} →
                                {{ $singleApp->return_date->format('d M Y') }}
                                ({{ $singleApp->getDurationDays() }} days)
                            </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Report --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-file-text me-2" style="color:#1a3a6b;"></i>Trip Report
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">
                                        Report Summary <span class="text-danger">*</span>
                                    </label>
                                    <textarea wire:model="report_summary" rows="6"
                                              class="form-control @error('report_summary') is-invalid @enderror"
                                              placeholder="Summarise what you did, meetings attended, outcomes achieved, and any recommendations..."></textarea>
                                    @error('report_summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="form-text">
                                            {{ strlen($report_summary) }} chars — minimum 50 required.
                                        </div>
                                        @enderror
                                </div>
                                <div>
                                    <label class="form-label fw-medium">Actual Cost Incurred (KES)</label>
                                    <input type="number" wire:model="actual_cost"
                                           class="form-control @error('actual_cost') is-invalid @enderror"
                                           placeholder="0.00" min="0" step="0.01">
                                    @error('actual_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">Optional — total expenditure for the trip.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Documents --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>Supporting Documents
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">
                                            Post-Trip Report <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" wire:model="doc_report"
                                               class="form-control @error('doc_report') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_report')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text">PDF or image — max 2MB</div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Travel Ticket / Boarding Pass</label>
                                        <input type="file" wire:model="doc_ticket"
                                               class="form-control @error('doc_ticket') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_ticket')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text">PDF or image — max 2MB</div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Passport (Stamped Pages)</label>
                                        <input type="file" wire:model="doc_passport"
                                               class="form-control @error('doc_passport') is-invalid @enderror"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_passport')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text">Entry/exit stamps — max 2MB</div>
                                    </div>
                                </div>
                                <div wire:loading
                                     wire:target="doc_report,doc_ticket,doc_passport"
                                     class="mt-2 d-flex align-items-center gap-2 text-muted"
                                     style="font-size:.82rem;">
                                    <span class="spinner-border spinner-border-sm"></span> Uploading...
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right column --}}
                    <div class="col-12 col-lg-4">
                        <div class="card mb-3 border-0" style="background:#e8f0fb;">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-2" style="color:#1a3a6b;font-size:.84rem;">
                                    <i class="bi bi-info-circle me-1"></i>What happens next?
                                </h6>
                                <ul class="mb-0 ps-3" style="font-size:.8rem;color:#374151;line-height:1.9;">
                                    <li>Your supervisor reviews your report and documents</li>
                                    <li>Supervisor closes the application</li>
                                    <li>You receive a confirmation notification</li>
                                    <li>You can then submit a new travel application</li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"
                                    wire:loading.attr="disabled"
                                    @if(!$activeAppId) disabled @endif>
                        <span wire:loading.remove>
                            <i class="bi bi-upload me-1"></i> Submit Post-Trip Documents
                        </span>
                                <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>Submitting...
                        </span>
                            </button>
                            <a href="{{ route('travel.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        {{-- Submitted / Closed --}}
        @if($submittedApps->count())
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>
                        Recent Post-Trip Submissions
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($submittedApps as $sApp)
                        <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}
                flex-wrap">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-medium" style="font-size:.88rem;">
                            {{ $sApp->reference_number }}
                        </span>
                                    <span
                                        class="badge {{ $sApp->status === 'closed' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }}"
                                        style="font-size:.72rem;">
                            {{ $sApp->status === 'closed' ? 'Closed' : 'Pending Review' }}
                        </span>
                                </div>
                                <div class="text-muted" style="font-size:.78rem;">
                                    {{ $sApp->country?->name ?? ($sApp->county?->name . ' County') }}
                                    &mdash;
                                    Submitted {{ $sApp->postTripUpload?->submitted_at?->format('d M Y') ?? '—' }}
                                </div>
                            </div>
                            <a href="{{ route('travel.show', $sApp->id) }}"
                               class="btn btn-sm btn-outline-secondary py-0 px-2"
                               style="font-size:.78rem;">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
