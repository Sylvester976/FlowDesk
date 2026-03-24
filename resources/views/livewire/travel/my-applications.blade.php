<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">My Applications</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">My Applications</span>
            </nav>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('travel.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i>
                <span class="d-none d-sm-inline">New Application</span>
            </a>
        </div>
    </div>

    {{-- Pending uploads alert --}}
    @if($hasPendingUploads)
    <div class="alert d-flex align-items-start gap-3 mb-3"
        style="background:#fff8e1;border:1px solid #f0c040;border-left:4px solid #c8a951;border-radius:8px;">
        <i class="bi bi-exclamation-triangle-fill mt-1" style="color:#c8a951;font-size:1.1rem;flex-shrink:0;"></i>
        <div class="flex-grow-1">
            <div class="fw-semibold" style="color:#78620a;font-size:.88rem;">Post-trip uploads pending</div>
            <div style="font-size:.82rem;color:#78620a;margin-top:2px;">
                You must upload post-trip documents before you can apply for new travel.
            </div>
        </div>
        <a href="{{ route('travel.post-trip') }}" class="btn btn-sm btn-warning py-1">
            Upload Now
        </a>
    </div>
    @endif

    {{-- Days docket --}}
    @php $user = auth()->user(); @endphp
    @if($user->role?->hierarchy_level >= 2)
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div class="fw-bold fs-4" style="color:#1a3a6b;">{{ $user->days_used_this_year }}</div>
                <div class="text-muted" style="font-size:.78rem;">Days used</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div class="fw-bold fs-4" style="color:#006b3f;">{{ $user->days_remaining }}</div>
                <div class="text-muted" style="font-size:.78rem;">Days remaining</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div class="fw-bold fs-4" style="color:#374151;">{{ $user->max_days_per_year }}</div>
                <div class="text-muted" style="font-size:.78rem;">Annual limit</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center py-3">
                <div class="fw-bold fs-4" style="color:#c8a951;">{{ now()->year }}</div>
                <div class="text-muted" style="font-size:.78rem;">Current year</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <select wire:model.live="filterType" class="form-select form-select-sm">
                        <option value="">All types</option>
                        <option value="foreign_official">Foreign Official</option>
                        <option value="foreign_private">Foreign Private</option>
                        <option value="local">Local</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select wire:model.live="filterStatus" class="form-select form-select-sm">
                        <option value="">All statuses</option>
                        <option value="submitted">Submitted</option>
                        <option value="pending_concurrence">Awaiting Concurrence</option>
                        <option value="concurred">Concurred</option>
                        <option value="not_concurred">Not Concurred</option>
                        <option value="returned">Returned</option>
                        <option value="pending_uploads">Post-trip Pending</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Applications list --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Type</th>
                            <th class="d-none d-md-table-cell">Destination</th>
                            <th class="d-none d-sm-table-cell">Dates</th>
                            <th>Status</th>
                            <th style="width:80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                        <tr wire:key="app-{{ $app->id }}">
                            <td>
                                <div class="fw-medium" style="font-size:.85rem;">
                                    {{ $app->reference_number }}
                                </div>
                                <div class="text-muted" style="font-size:.74rem;">
                                    {{ $app->created_at->format('d M Y') }}
                                </div>
                                {{-- Mobile extras --}}
                                <div class="d-sm-none text-muted" style="font-size:.74rem;">
                                    {{ $app->departure_date->format('d M Y') }} →
                                    {{ $app->return_date->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $typeColor = match($app->travel_type) {
                                        'foreign_official' => '#1a3a6b',
                                        'foreign_private'  => '#006b3f',
                                        'local'            => '#78620a',
                                    };
                                @endphp
                                <span class="badge" style="background:{{ $typeColor }}1a;
                                    color:{{ $typeColor }};font-size:.72rem;font-weight:500;">
                                    {{ $app->getTravelTypeLabel() }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                @if($app->country) {{ $app->country->name }}
                                @elseif($app->county) {{ $app->county->name }} County
                                @endif
                                @if($app->destination_details)
                                    <div class="text-muted" style="font-size:.75rem;">
                                        {{ $app->destination_details }}
                                    </div>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell" style="font-size:.83rem;">
                                {{ $app->departure_date->format('d M') }} →
                                {{ $app->return_date->format('d M Y') }}
                                <div class="text-muted" style="font-size:.75rem;">
                                    {{ $app->getDurationDays() }} day(s)
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $app->getStatusColor() }}-subtle
                                    text-{{ $app->getStatusColor() }}
                                    border border-{{ $app->getStatusColor() }}-subtle"
                                    style="font-size:.73rem;">
                                    {{ $app->getStatusLabel() }}
                                </span>
                                @if($app->status === 'returned')
                                    <div class="text-danger" style="font-size:.72rem;margin-top:2px;">
                                        <i class="bi bi-chat-left-text me-1"></i>Has comments
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('travel.show', $app->id) }}"
                                    class="btn btn-sm btn-outline-primary p-1"
                                    style="width:28px;height:28px;display:flex;align-items:center;
                                    justify-content:center;" title="View">
                                    <i class="bi bi-eye" style="font-size:.75rem;"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-airplane fs-2 d-block mb-2"></i>
                                No applications yet.
                                <a href="{{ route('travel.create') }}" class="d-block mt-2">
                                    Submit your first application
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($applications->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }}
                of {{ $applications->total() }}
            </div>
            {{ $applications->links() }}
        </div>
        @endif
    </div>

</div>
</div>
