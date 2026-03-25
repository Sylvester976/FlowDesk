<div>
    <div class="main-content">

        @php $app = $application; @endphp

        <div class="page-header">
            <div>
                <h1 class="page-title">Revise Application</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <a href="{{ route('travel.index') }}" class="breadcrumb-item">My Applications</a>
                    <a href="{{ route('travel.show', $app->id) }}"
                       class="breadcrumb-item">{{ $app->reference_number }}</a>
                    <span class="breadcrumb-item active">Revise</span>
                </nav>
            </div>
        </div>

        {{-- Returned reason banner --}}
        @php $returnStep = $app->concurrenceSteps->where('action', 'returned')->last(); @endphp
        @if($returnStep)
            <div class="card mb-3 border-0" style="background:#fff8e1;border-left:4px solid #c8a951 !important;">
                <div class="card-body py-2">
                    <div class="fw-semibold mb-1" style="color:#78620a;font-size:.85rem;">
                        <i class="bi bi-arrow-return-left me-1"></i>
                        Returned by {{ $returnStep->approver->full_name }}
                        on {{ $returnStep->acted_at?->format('d M Y, H:i') }}
                    </div>
                    @if($returnStep->comments)
                        <div style="font-size:.83rem;color:#78620a;">{{ $returnStep->comments }}</div>
                    @endif
                </div>
            </div>
        @endif

        <form wire:submit="resubmit" novalidate>
            <div class="row g-3">
                <div class="col-12 col-lg-8">

                    {{-- Trip details --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-map me-2" style="color:#1a3a6b;"></i>Trip Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">

                                {{-- Destination (read only) --}}
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">Destination</label>
                                    <input type="text" class="form-control" disabled
                                           value="{{ $app->country?->name ?? ($app->county?->name . ' County') }}">
                                    <div class="form-text">Destination cannot be changed.</div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-medium">City / Specific Location</label>
                                    <input type="text" wire:model="destination_details" class="form-control"
                                           placeholder="e.g. Nairobi CBD">
                                </div>

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
                                    <label class="form-label fw-medium">Return Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" wire:model.live="return_date"
                                           class="form-control @error('return_date') is-invalid @enderror"
                                           min="{{ $departure_date ?: now()->format('Y-m-d') }}">
                                    @error('return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                @if(! $isNairobi && ! $app->isForeignPrivate())
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Per Diem Days <span
                                                class="text-danger">*</span></label>
                                        <input type="number" wire:model="per_diem_days"
                                               class="form-control @error('per_diem_days') is-invalid @enderror"
                                               min="0" max="365">
                                        @error('per_diem_days')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                @endif

                                @if($app->isForeignOfficial())
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Funding Source <span
                                                class="text-danger">*</span></label>
                                        <input type="text" wire:model="funding_source"
                                               class="form-control @error('funding_source') is-invalid @enderror">
                                        @error('funding_source')
                                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                @endif

                                <div class="col-12">
                                    <label class="form-label fw-medium">Purpose <span
                                            class="text-danger">*</span></label>
                                    <textarea wire:model="purpose" rows="5"
                                              class="form-control @error('purpose') is-invalid @enderror"></textarea>
                                    @error('purpose')
                                    <div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">{{ strlen($purpose) }} chars — min 30</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-paperclip me-2" style="color:#1a3a6b;"></i>Documents
                                <span class="text-muted fw-normal" style="font-size:.78rem;">
                                — upload new files to replace existing ones
                            </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            {{-- Current documents --}}
                            @if($app->documents->count())
                                <div class="mb-3">
                                    <div class="text-muted mb-2"
                                         style="font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;">Current
                                        documents
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($app->documents as $doc)
                                            <span
                                                class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-file-earmark me-1"></i>{{ $doc->getTypeLabel() }}
                                </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="row g-3">
                                @if($app->isForeignOfficial())
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Invitation Letter</label>
                                        <input type="file" wire:model="doc_invitation" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_invitation')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Appointment Letter</label>
                                        <input type="file" wire:model="doc_appointment" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_appointment')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Passport Copy</label>
                                        <input type="file" wire:model="doc_passport" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_passport')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                @endif

                                @if($app->isForeignPrivate())
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Passport Copy</label>
                                        <input type="file" wire:model="doc_passport" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_passport')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Leave Form</label>
                                        <input type="file" wire:model="doc_leave_form" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_leave_form')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                @endif

                                @if($app->isLocal())
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label fw-medium">Replace Appointment Letter</label>
                                        <input type="file" wire:model="doc_appointment" class="form-control"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                        @error('doc_appointment')
                                        <div class="text-danger small">{{ $message }}</div>@enderror
                                        <div class="form-text">Leave empty to keep existing</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right column --}}
                <div class="col-12 col-lg-4">
                    <div class="card mb-3 border-0" style="background:#e8f0fb;">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-2" style="color:#1a3a6b;font-size:.84rem;">
                                <i class="bi bi-info-circle me-1"></i>What happens on resubmit?
                            </h6>
                            <ul class="mb-0 ps-3" style="font-size:.8rem;color:#374151;line-height:1.9;">
                                <li>Application goes back to your supervisor</li>
                                <li>Supervisor gets notified again</li>
                                <li>Reference number stays the same</li>
                                <li>Previous comments are preserved in the log</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-send me-1"></i> Resubmit Application
                        </span>
                            <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>Submitting...
                        </span>
                        </button>
                        <a href="{{ route('travel.show', $app->id) }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
