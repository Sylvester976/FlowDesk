<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Days Docket — {{ now()->year }}</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Days Docket</span>
            </nav>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold" style="font-size:1.8rem;color:#1a3a6b;">{{ $summary['total'] }}</div>
                    <div class="text-muted" style="font-size:.78rem;">Total Staff</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold" style="font-size:1.8rem;color:#006b3f;">{{ $summary['ok'] }}</div>
                    <div class="text-muted" style="font-size:.78rem;">Within Limit</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold" style="font-size:1.8rem;color:#c8a951;">{{ $summary['warning'] }}</div>
                    <div class="text-muted" style="font-size:.78rem;">Warning ≥80%</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold" style="font-size:1.8rem;color:#bb0000;">{{ $summary['exceeded'] }}</div>
                    <div class="text-muted" style="font-size:.78rem;">Exceeded Limit</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-4 col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control" placeholder="Name or PF number...">
                    </div>
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
                    <select wire:model.live="filterWarning" class="form-select form-select-sm">
                        <option value="">All Staff</option>
                        <option value="exceeded">Exceeded</option>
                        <option value="warning">Warning (≥80%)</option>
                        <option value="ok">Within Limit</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Docket table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <button wire:click="sort('last_name')"
                                    class="btn btn-link p-0 text-decoration-none fw-semibold"
                                    style="font-size:.82rem;color:var(--bs-body-color);">
                                    Staff
                                    @if($sortBy === 'last_name')
                                        <i class="bi bi-chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}"
                                            style="font-size:.65rem;"></i>
                                    @endif
                                </button>
                            </th>
                            <th class="d-none d-md-table-cell">Directorate</th>
                            <th class="d-none d-sm-table-cell">Role</th>
                            <th>
                                <button wire:click="sort('days_used_this_year')"
                                    class="btn btn-link p-0 text-decoration-none fw-semibold"
                                    style="font-size:.82rem;color:var(--bs-body-color);">
                                    Days Used
                                    @if($sortBy === 'days_used_this_year')
                                        <i class="bi bi-chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}"
                                            style="font-size:.65rem;"></i>
                                    @endif
                                </button>
                            </th>
                            <th class="d-none d-md-table-cell">Docket</th>
                            @if(auth()->user()->isSuperAdmin())
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        @php
                            $pct = $s->max_days_per_year > 0
                                ? min(100, round(($s->days_used_this_year / $s->max_days_per_year) * 100))
                                : 0;
                            $color = $pct >= 100 ? '#bb0000' : ($pct >= 80 ? '#c8a951' : '#006b3f');
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-medium" style="font-size:.84rem;">
                                    {{ $s->full_name }}
                                </div>
                                <div class="text-muted" style="font-size:.72rem;">
                                    PF: {{ $s->pf_number ?? '—' }}
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.82rem;">
                                {{ $s->department?->directorate?->name ?? '—' }}
                            </td>
                            <td class="d-none d-sm-table-cell" style="font-size:.82rem;">
                                {{ $s->role?->label ?? '—' }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="flex-grow-1 d-none d-sm-block" style="min-width:80px;">
                                        <div class="progress" style="height:5px;border-radius:4px;">
                                            <div class="progress-bar" style="width:{{ $pct }}%;
                                                background:{{ $color }};border-radius:4px;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="fw-semibold" style="color:{{ $color }};font-size:.85rem;">
                                            {{ $s->days_used_this_year }}
                                        </span>
                                        <span class="text-muted" style="font-size:.78rem;">
                                            / {{ $s->max_days_per_year }}d
                                        </span>
                                    </div>
                                    <span class="badge" style="font-size:.7rem;
                                        background:{{ $pct >= 100 ? '#ffebee' : ($pct >= 80 ? '#fff8e1' : '#e8f5ee') }};
                                        color:{{ $color }};">
                                        {{ $pct }}%
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div style="width:160px;">
                                    <div class="progress" style="height:8px;border-radius:6px;">
                                        <div class="progress-bar" style="width:{{ $pct }}%;
                                            background:{{ $color }};border-radius:6px;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <span style="font-size:.68rem;color:var(--bs-secondary-color);">0</span>
                                        <span style="font-size:.68rem;color:var(--bs-secondary-color);">
                                            {{ $s->max_days_per_year }}d max
                                        </span>
                                    </div>
                                </div>
                            </td>
                            @if(auth()->user()->isSuperAdmin())
                            <td>
                                @if($s->days_used_this_year > 0)
                                <button wire:click="resetDocket({{ $s->id }})"
                                    wire:confirm="Reset days docket for {{ $s->full_name }}? This cannot be undone."
                                    class="btn btn-sm btn-outline-danger py-0 px-2"
                                    style="font-size:.74rem;"
                                    title="Reset docket">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                No staff found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($staff->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $staff->firstItem() }}–{{ $staff->lastItem() }}
                of {{ $staff->total() }}
            </div>
            {{ $staff->links() }}
        </div>
        @endif
    </div>

</div>
</div>
