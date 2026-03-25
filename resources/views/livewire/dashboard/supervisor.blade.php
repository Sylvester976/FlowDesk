<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Supervisor Dashboard</h1>
            <p class="text-muted mb-0" style="font-size:.88rem;">
                Welcome, {{ auth()->user()->first_name }} &mdash;
                {{ auth()->user()->role?->label }}
            </p>
        </div>
    </div>

    {{-- ── My Travel summary ──────────────────────────────── --}}
    @include('livewire.dashboard._my_travel_summary')

    {{-- ── Summary stats ───────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center py-3">
                    <div class="fw-bold mb-1"
                        style="font-size:2rem;color:{{ $pendingConcurrences > 0 ? '#bb0000' : '#006b3f' }};">
                        {{ $pendingConcurrences }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Pending Concurrence</div>
                    @if($pendingConcurrences > 0)
                    <a href="{{ route('travel.concurrence') }}"
                        class="btn btn-sm btn-danger py-0 px-2 mt-2" style="font-size:.74rem;">
                        Action Now
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center py-3">
                    <div class="fw-bold mb-1"
                        style="font-size:2rem;color:{{ $pendingPostTrip > 0 ? '#c8a951' : '#006b3f' }};">
                        {{ $pendingPostTrip }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Post-Trip Reviews</div>
                    @if($pendingPostTrip > 0)
                    <a href="{{ route('travel.post-trip-review') }}"
                        class="btn btn-sm btn-warning py-0 px-2 mt-2" style="font-size:.74rem;">
                        Review
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center py-3">
                    <div class="fw-bold mb-1" style="font-size:2rem;color:#1a3a6b;">
                        {{ $outOfOffice->count() }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Currently Out</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center py-3">
                    <div class="fw-bold mb-1" style="font-size:2rem;color:#1a3a6b;">
                        {{ $totalTeamApps }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Team Apps This Year</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">

            {{-- Out of office --}}
            @if($outOfOffice->count())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt me-2" style="color:#bb0000;"></i>
                        Currently Out of Office
                        <span class="badge bg-danger ms-1" style="font-size:.7rem;">
                            {{ $outOfOffice->count() }}
                        </span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($outOfOffice as $app)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                            {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.85rem;">{{ $app->user->full_name }}</div>
                            <div class="text-muted" style="font-size:.76rem;">
                                {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                &mdash; returns {{ $app->return_date->format('d M Y') }}
                                @if($app->return_date->isPast())
                                    <span class="text-danger">(overdue)</span>
                                @else
                                    ({{ $app->return_date->diffForHumans() }})
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('travel.show', $app->id) }}"
                            class="btn btn-sm btn-outline-secondary py-0 px-2"
                            style="font-size:.74rem;">View</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Team travel history --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people me-2" style="color:#1a3a6b;"></i>
                        Team Travel History
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th class="d-none d-md-table-cell">Destination</th>
                                    <th class="d-none d-sm-table-cell">Dates</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teamApps as $app)
                                <tr>
                                    <td>
                                        <div class="fw-medium" style="font-size:.84rem;">
                                            {{ $app->user->full_name }}
                                        </div>
                                        <div class="text-muted" style="font-size:.74rem;">
                                            {{ $app->reference_number }}
                                        </div>
                                        <div class="d-md-none text-muted" style="font-size:.74rem;">
                                            {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                        {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                    </td>
                                    <td class="d-none d-sm-table-cell" style="font-size:.82rem;">
                                        {{ $app->departure_date->format('d M') }} →
                                        {{ $app->return_date->format('d M Y') }}
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
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No team travel records yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">

            {{-- Top travellers --}}
            @if($topTravellers->count())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trophy me-2" style="color:#c8a951;"></i>
                        Most Travelled (Days Used)
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($topTravellers as $i => $staff)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;
                            background:{{ $i === 0 ? '#c8a951' : ($i === 1 ? '#9ca3af' : ($i === 2 ? '#c8764a' : '#e8f0fb')) }};
                            color:{{ $i < 3 ? '#fff' : '#1a3a6b' }};
                            display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;font-weight:700;flex-shrink:0;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.85rem;">{{ $staff->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">{{ $staff->role?->label }}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold" style="color:#1a3a6b;font-size:.9rem;">
                                {{ $staff->days_used_this_year }}d
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                of {{ $staff->max_days_per_year }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Top countries --}}
            @if($topCountries->count())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-globe me-2" style="color:#1a3a6b;"></i>
                        Most Visited Countries
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($topCountries as $i => $c)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;background:#1a3a6b;
                            color:#fff;display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;font-weight:700;flex-shrink:0;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1 fw-medium" style="font-size:.85rem;">{{ $c['name'] }}</div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle"
                            style="font-size:.75rem;">
                            {{ $c['count'] }} trip{{ $c['count'] > 1 ? 's' : '' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</div>
