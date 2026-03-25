<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">All Applications</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">All Applications</span>
            </nav>
        </div>
    </div>

    {{-- Summary stats --}}
    <div class="row g-3 mb-3">
        @foreach([
            ['label' => 'Total This Year',     'value' => $counts['total'],               'color' => '#1a3a6b', 'bg' => '#e8f0fb'],
            ['label' => 'Pending Concurrence', 'value' => $counts['pending_concurrence'], 'color' => '#bb0000', 'bg' => '#ffebee'],
            ['label' => 'Concurred',           'value' => $counts['concurred'],           'color' => '#006b3f', 'bg' => '#e8f5ee'],
            ['label' => 'Closed',              'value' => $counts['closed'],              'color' => '#6c757d', 'bg' => '#f8f9fa'],
        ] as $stat)
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;border-radius:10px;flex-shrink:0;
                        background:{{ $stat['bg'] }};display:flex;align-items:center;justify-content:center;">
                        <span class="fw-bold" style="color:{{ $stat['color'] }};font-size:1rem;">
                            {{ $stat['value'] }}
                        </span>
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">{{ $stat['label'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-4 col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control" placeholder="Name, PF, reference...">
                    </div>
                </div>
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterStatus" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="submitted">Submitted</option>
                        <option value="pending_concurrence">Pending Concurrence</option>
                        <option value="concurred">Concurred</option>
                        <option value="returned">Returned</option>
                        <option value="not_concurred">Not Concurred</option>
                        <option value="pending_uploads">Pending Uploads</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterType" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="foreign_official">Foreign Official</option>
                        <option value="foreign_private">Foreign Private</option>
                        <option value="local">Local</option>
                    </select>
                </div>
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterDirectorate" class="form-select form-select-sm">
                        <option value="">All Directorates</option>
                        @foreach($directorates as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterYear" class="form-select form-select-sm">
                        <option value="">All Years</option>
                        @foreach($years as $yr)
                        <option value="{{ $yr }}">{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <button wire:click="sort('reference_number')"
                                    class="btn btn-link p-0 text-decoration-none fw-semibold"
                                    style="font-size:.82rem;color:var(--bs-body-color);">
                                    Reference
                                    @if($sortBy === 'reference_number')
                                        <i class="bi bi-chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}" style="font-size:.65rem;"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Staff</th>
                            <th class="d-none d-md-table-cell">Directorate</th>
                            <th class="d-none d-sm-table-cell">Destination</th>
                            <th class="d-none d-lg-table-cell">
                                <button wire:click="sort('departure_date')"
                                    class="btn btn-link p-0 text-decoration-none fw-semibold"
                                    style="font-size:.82rem;color:var(--bs-body-color);">
                                    Dates
                                    @if($sortBy === 'departure_date')
                                        <i class="bi bi-chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}" style="font-size:.65rem;"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                        <tr>
                            <td>
                                <a href="{{ route('travel.show', $app->id) }}"
                                    style="color:#1a3a6b;font-weight:500;font-size:.83rem;">
                                    {{ $app->reference_number }}
                                </a>
                                <div class="text-muted" style="font-size:.72rem;">
                                    {{ $app->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium" style="font-size:.83rem;">
                                    {{ $app->user->full_name }}
                                </div>
                                <div class="text-muted" style="font-size:.72rem;">
                                    {{ $app->user->role?->label }}
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.82rem;">
                                {{ $app->user->department?->directorate?->name ?? '—' }}
                            </td>
                            <td class="d-none d-sm-table-cell" style="font-size:.82rem;">
                                {{ $app->country?->name ?? ($app->county?->name . ' County') ?? '—' }}
                            </td>
                            <td class="d-none d-lg-table-cell" style="font-size:.8rem;">
                                {{ $app->departure_date->format('d M Y') }} →
                                {{ $app->return_date->format('d M Y') }}
                                <span class="text-muted">({{ $app->getDurationDays() }}d)</span>
                            </td>
                            <td>
                                <span class="badge" style="font-size:.72rem;
                                    background:{{ match($app->travel_type) {
                                        'foreign_official' => '#e8f0fb',
                                        'foreign_private'  => '#e8f5ee',
                                        'local'            => '#fff8e1',
                                    } }};
                                    color:{{ match($app->travel_type) {
                                        'foreign_official' => '#1a3a6b',
                                        'foreign_private'  => '#006b3f',
                                        'local'            => '#78620a',
                                    } }};">
                                    {{ $app->getTravelTypeLabel() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $app->getStatusColor() }}-subtle
                                    text-{{ $app->getStatusColor() }}
                                    border border-{{ $app->getStatusColor() }}-subtle"
                                    style="font-size:.72rem;">
                                    {{ $app->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                No applications found.
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
