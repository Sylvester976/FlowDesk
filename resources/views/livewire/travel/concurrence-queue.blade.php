<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Concurrence Queue</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Concurrence Queue</span>
            </nav>
        </div>
        @if($pendingCount > 0)
        <div class="page-header-actions">
            <span class="badge bg-warning text-dark px-3 py-2" style="font-size:.82rem;">
                <i class="bi bi-clock me-1"></i>
                {{ $pendingCount }} pending action{{ $pendingCount > 1 ? 's' : '' }}
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
                        Pending
                        @if($pendingCount > 0)
                            <span class="badge bg-warning text-dark ms-1" style="font-size:.68rem;">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="$set('filterStatus', 'actioned')"
                        class="nav-link {{ $filterStatus === 'actioned' ? 'active' : '' }} py-1 px-3"
                        style="font-size:.84rem;">
                        Actioned
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

    {{-- Queue --}}
    <div class="card">
        <div class="card-body p-0">
            @forelse($queue as $app)
            @php
                $myStep = $app->concurrenceSteps->first();
                $isPending = $myStep?->action === 'pending';
            @endphp
            <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}"
                wire:key="app-{{ $app->id }}">
                <div class="row g-3 align-items-start">

                    {{-- Left: applicant + trip info --}}
                    <div class="col-12 col-md-6 col-lg-7">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="user-initials-avatar" style="width:36px;height:36px;font-size:.72rem;flex-shrink:0;">
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
                            <span class="badge"
                                style="background:#1a3a6b1a;color:#1a3a6b;font-size:.73rem;">
                                {{ $app->reference_number }}
                            </span>
                            <span class="badge"
                                style="background:#006b3f1a;color:#006b3f;font-size:.73rem;">
                                {{ $app->getTravelTypeLabel() }}
                            </span>
                            @if(! $isPending)
                            @php
                                $ac = match($myStep?->action) {
                                    'concurred'     => 'success',
                                    'not_concurred' => 'danger',
                                    'returned'      => 'warning',
                                    default         => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $ac }}-subtle text-{{ $ac }} border border-{{ $ac }}-subtle"
                                style="font-size:.73rem;">
                                {{ ucfirst(str_replace('_', ' ', $myStep?->action)) }}
                            </span>
                            @endif
                        </div>

                        <div class="row g-2" style="font-size:.83rem;">
                            <div class="col-12 col-sm-6">
                                <span class="text-muted">Destination:</span>
                                <span class="fw-medium ms-1">
                                    @if($app->country) {{ $app->country->name }}
                                    @elseif($app->county) {{ $app->county->name }} County
                                    @endif
                                    @if($app->destination_details)
                                        — {{ $app->destination_details }}
                                    @endif
                                </span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted">Dates:</span>
                                <span class="fw-medium ms-1">
                                    {{ $app->departure_date->format('d M Y') }}
                                    → {{ $app->return_date->format('d M Y') }}
                                    <span class="text-muted">({{ $app->getDurationDays() }}d)</span>
                                </span>
                            </div>
                            @if($app->per_diem_days)
                            <div class="col-12 col-sm-6">
                                <span class="text-muted">Per diem days:</span>
                                <span class="fw-medium ms-1">{{ $app->per_diem_days }}</span>
                            </div>
                            @endif
                            @if($app->funding_source)
                            <div class="col-12 col-sm-6">
                                <span class="text-muted">Funding:</span>
                                <span class="fw-medium ms-1">{{ $app->funding_source }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Purpose preview --}}
                        <div class="mt-2 p-2 rounded" style="background:var(--bs-tertiary-bg);font-size:.82rem;line-height:1.6;">
                            {{ Str::limit($app->purpose, 200) }}
                        </div>

                        {{-- Previous concurrence comments --}}
                        @if(! $isPending && $myStep?->comments)
                        <div class="mt-2 p-2 rounded d-flex gap-2"
                            style="background:#fff8e1;border-left:3px solid #c8a951;font-size:.8rem;">
                            <i class="bi bi-chat-left-text text-warning flex-shrink-0 mt-1"></i>
                            <span>{{ $myStep->comments }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Right: actions --}}
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('travel.show', $app->id) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye me-1"></i>
                                View Full Application
                            </a>

                            @if($isPending)
                            <div class="d-grid gap-2">
                                <button wire:click="openAction({{ $app->id }}, 'concurred')"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Concur
                                </button>
                                <button wire:click="openAction({{ $app->id }}, 'returned')"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-arrow-return-left me-1"></i>
                                    Return for Revision
                                </button>
                                <button wire:click="openAction({{ $app->id }}, 'not_concurred')"
                                    class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Not Concur
                                </button>
                            </div>
                            @else
                            <div class="p-2 rounded text-center text-muted" style="background:var(--bs-tertiary-bg);font-size:.8rem;">
                                <i class="bi bi-check2-all me-1"></i>
                                Actioned {{ $myStep?->acted_at?->format('d M Y, H:i') }}
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
                    No pending applications — all caught up.
                @else
                    No applications found.
                @endif
            </div>
            @endforelse
        </div>

        @if($queue->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $queue->firstItem() }}–{{ $queue->lastItem() }}
                of {{ $queue->total() }}
            </div>
            {{ $queue->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ── Action modal ─────────────────────────────────────── --}}
@if($showActionModal)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"
                style="background:{{ $action === 'concurred' ? '#e8f5ee' : ($action === 'not_concurred' ? '#ffebee' : '#fff8e1') }};">
                <h5 class="modal-title" style="color:{{ $action === 'concurred' ? '#006b3f' : ($action === 'not_concurred' ? '#bb0000' : '#78620a') }};">
                    <i class="bi {{ $action === 'concurred' ? 'bi-check-circle' : ($action === 'not_concurred' ? 'bi-x-circle' : 'bi-arrow-return-left') }} me-2"></i>
                    {{ $action === 'concurred' ? 'Concur Application' : ($action === 'not_concurred' ? 'Not Concur Application' : 'Return for Revision') }}
                </h5>
                <button wire:click="$set('showActionModal', false)" class="btn-close"></button>
            </div>
            <div class="modal-body">
                @if($action === 'concurred')
                <div class="p-3 rounded mb-3" style="background:#e8f5ee;border-left:4px solid #006b3f;">
                    <p class="mb-0" style="font-size:.84rem;color:#085041;">
                        <i class="bi bi-info-circle me-1"></i>
                        Concurring this application will:
                    </p>
                    <ul class="mb-0 mt-1 ps-3" style="font-size:.82rem;color:#085041;">
                        <li>Update the applicant's travel days docket</li>
                        <li>Generate a clearance letter automatically</li>
                        <li>Notify the applicant</li>
                    </ul>
                </div>
                @endif

                @if($action === 'not_concurred')
                <div class="p-3 rounded mb-3" style="background:#ffebee;border-left:4px solid #bb0000;">
                    <p class="mb-0" style="font-size:.84rem;color:#7f0000;">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Not concurring is final. The application will be rejected and the applicant cannot resubmit it.
                    </p>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-medium">
                        Comments
                        @if(in_array($action, ['not_concurred', 'returned']))
                            <span class="text-danger">*</span>
                        @else
                            <span class="text-muted fw-normal" style="font-size:.78rem;">(optional)</span>
                        @endif
                    </label>
                    <textarea wire:model="comments" rows="4"
                        class="form-control"
                        placeholder="{{ $action === 'concurred'
                            ? 'Add any notes or conditions (optional)...'
                            : ($action === 'returned'
                                ? 'Explain what needs to be revised...'
                                : 'Explain why this application is not being concurred...') }}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showActionModal', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="executeAction"
                    class="btn btn-sm px-4 {{ $action === 'concurred' ? 'btn-success' : ($action === 'not_concurred' ? 'btn-danger' : 'btn-warning') }}"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        {{ $action === 'concurred' ? 'Confirm Concurrence' : ($action === 'not_concurred' ? 'Confirm Not Concur' : 'Return for Revision') }}
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm me-1"></span>Processing...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>
