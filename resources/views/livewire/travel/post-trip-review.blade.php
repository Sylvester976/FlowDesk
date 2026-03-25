<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">Post-Trip Review</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <span class="breadcrumb-item active">Post-Trip Review</span>
                </nav>
            </div>
            @if($pendingCount > 0)
                <div class="page-header-actions">
            <span class="badge bg-warning text-dark px-3 py-2" style="font-size:.82rem;">
                <i class="bi bi-clock me-1"></i>
                {{ $pendingCount }} pending review{{ $pendingCount > 1 ? 's' : '' }}
            </span>
                </div>
            @endif
        </div>

        {{-- Filter --}}
        <div class="card mb-3">
            <div class="card-body py-2">
                <ul class="nav nav-pills gap-1">
                    <li class="nav-item">
                        <button wire:click="$set('filterStatus', 'pending')"
                                class="nav-link {{ $filterStatus === 'pending' ? 'active' : '' }} py-1 px-3"
                                style="font-size:.84rem;">
                            Pending Review
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark ms-1" style="font-size:.68rem;">
                            {{ $pendingCount }}
                        </span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="$set('filterStatus', 'closed')"
                                class="nav-link {{ $filterStatus === 'closed' ? 'active' : '' }} py-1 px-3"
                                style="font-size:.84rem;">
                            Closed
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="$set('filterStatus', 'all')"
                                class="nav-link {{ $filterStatus === 'all' ? 'active' : '' }} py-1 px-3"
                                style="font-size:.84rem;">
                            All
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                @forelse($apps as $app)
                    @php $upload = $app->postTripUpload; @endphp
                    <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}"
                         wire:key="pt-{{ $app->id }}">
                        <div class="row g-3">

                            {{-- Applicant + trip info --}}
                            <div class="col-12 col-lg-7">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="user-initials-avatar"
                                         style="width:36px;height:36px;font-size:.72rem;flex-shrink:0;">
                                        {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:.9rem;">
                                            {{ $app->user->full_name }}
                                        </div>
                                        <div class="text-muted" style="font-size:.78rem;">
                                            {{ $app->user->role?->label }}
                                            @if($app->user->department)
                                                &mdash; {{ $app->user->department->name }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge" style="background:#1a3a6b1a;color:#1a3a6b;font-size:.73rem;">
                                {{ $app->reference_number }}
                            </span>
                                    <span class="badge {{ $app->status === 'closed'
                                ? 'bg-success-subtle text-success border border-success-subtle'
                                : 'bg-warning-subtle text-warning border border-warning-subtle' }}"
                                          style="font-size:.73rem;">
                                {{ $app->status === 'closed' ? 'Closed' : 'Pending Review' }}
                            </span>
                                </div>

                                <div class="row g-2 mb-3" style="font-size:.83rem;">
                                    <div class="col-12 col-sm-6">
                                        <span class="text-muted">Destination:</span>
                                        <span class="fw-medium ms-1">
                                    {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                </span>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <span class="text-muted">Dates:</span>
                                        <span class="fw-medium ms-1">
                                    {{ $app->departure_date->format('d M Y') }}
                                    → {{ $app->return_date->format('d M Y') }}
                                </span>
                                    </div>
                                    @if($upload?->actual_cost)
                                        <div class="col-12 col-sm-6">
                                            <span class="text-muted">Actual cost:</span>
                                            <span class="fw-medium ms-1">
                                    KES {{ number_format($upload->actual_cost, 2) }}
                                </span>
                                        </div>
                                    @endif
                                    @if($upload?->submitted_at)
                                        <div class="col-12 col-sm-6">
                                            <span class="text-muted">Submitted:</span>
                                            <span class="fw-medium ms-1">
                                    {{ $upload->submitted_at->format('d M Y, H:i') }}
                                </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Report summary --}}
                                @if($upload?->report_summary)
                                    <div class="p-3 rounded"
                                         style="background:var(--bs-tertiary-bg);font-size:.83rem;line-height:1.7;">
                                        <div class="text-muted mb-1"
                                             style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">
                                            Trip Report
                                        </div>
                                        {{ $upload->report_summary }}
                                    </div>
                                @endif

                                {{-- Post-trip documents --}}
                                @if($app->documents->count())
                                    <div class="mt-2">
                                        <div class="text-muted mb-1"
                                             style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">
                                            Documents
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($app->documents as $doc)
                                                @php
                                                    $isPdf = strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION)) === 'pdf'
                                                        || $doc->mime_type === 'application/pdf';
                                                @endphp
                                                <a href="{{ route('travel.document', $doc->id) }}"
                                                   target="_blank"
                                                   class="d-flex align-items-center gap-1 px-2 py-1 rounded border text-decoration-none"
                                                   style="font-size:.78rem;color:var(--bs-body-color);">
                                                    <i class="bi {{ $isPdf ? 'bi-file-earmark-pdf text-danger' : 'bi-file-earmark-image text-primary' }}"></i>
                                                    {{ $doc->getTypeLabel() }}
                                                    <i class="bi bi-box-arrow-up-right text-muted"
                                                       style="font-size:.7rem;"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="col-12 col-lg-5">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('travel.show', $app->id) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye me-1"></i> View Full Application
                                    </a>

                                    @if($app->status === 'pending_uploads')
                                        <button wire:click="closeApplication({{ $app->id }})"
                                                wire:confirm="Close this application? This will notify the applicant and free them to submit new travel."
                                                class="btn btn-success btn-sm">
                                            <i class="bi bi-check2-circle me-1"></i>
                                            Review Done — Close Application
                                        </button>
                                    @else
                                        <div class="p-2 rounded text-center text-muted"
                                             style="background:var(--bs-tertiary-bg);font-size:.8rem;">
                                            <i class="bi bi-check-circle text-success me-1"></i>
                                            Closed
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        @if($filterStatus === 'pending')
                            No post-trip documents awaiting review.
                        @else
                            No records found.
                        @endif
                    </div>
                @endforelse
            </div>

            @if($apps->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing {{ $apps->firstItem() }}–{{ $apps->lastItem() }} of {{ $apps->total() }}
                    </div>
                    {{ $apps->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
