<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">PS Dashboard</h1>
            <p class="text-muted mb-0" style="font-size:.88rem;">
                Welcome back, {{ auth()->user()->first_name }} &mdash; {{ $year }} Overview
            </p>
        </div>
    </div>

    {{-- ── My Travel summary ──────────────────────────────── --}}
    @include('livewire.dashboard._my_travel_summary')

    {{-- ── Summary stats ───────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">Total Applications</div>
                            <div class="fw-bold" style="font-size:1.8rem;color:#1a3a6b;line-height:1.1;">{{ $totalAppsYear }}</div>
                            <div class="text-muted" style="font-size:.74rem;">this year</div>
                        </div>
                        <div style="width:40px;height:40px;border-radius:10px;background:#e8f0fb;
                            display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-airplane" style="color:#1a3a6b;font-size:1rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">Pending Concurrence</div>
                            <div class="fw-bold" style="font-size:1.8rem;line-height:1.1;
                                color:{{ $pendingConcurrences > 0 ? '#bb0000' : '#006b3f' }};">
                                {{ $pendingConcurrences }}
                            </div>
                            <a href="{{ route('travel.concurrence') }}" style="font-size:.74rem;color:#1a3a6b;">
                                View queue →
                            </a>
                        </div>
                        <div style="width:40px;height:40px;border-radius:10px;
                            background:{{ $pendingConcurrences > 0 ? '#ffebee' : '#e8f5ee' }};
                            display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-check" style="color:{{ $pendingConcurrences > 0 ? '#bb0000' : '#006b3f' }};font-size:1rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">Out of Office</div>
                            <div class="fw-bold" style="font-size:1.8rem;color:#1a3a6b;line-height:1.1;">
                                {{ $outOfOffice->count() }}
                            </div>
                            <div class="text-muted" style="font-size:.74rem;">currently travelling</div>
                        </div>
                        <div style="width:40px;height:40px;border-radius:10px;background:#fff8e1;
                            display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-geo-alt" style="color:#c8a951;font-size:1rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted mb-1" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;">Active Staff</div>
                            <div class="fw-bold" style="font-size:1.8rem;color:#1a3a6b;line-height:1.1;">{{ $totalStaff }}</div>
                            <div class="text-muted" style="font-size:.74rem;">in system</div>
                        </div>
                        <div style="width:40px;height:40px;border-radius:10px;background:#e8f5ee;
                            display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-people" style="color:#006b3f;font-size:1rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Charts row ──────────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2" style="color:#1a3a6b;"></i>
                        Applications by Month — {{ $year }}
                    </h5>
                </div>
                <div class="card-body">
                    <div id="appsMonthChart" style="min-height:240px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2" style="color:#1a3a6b;"></i>
                        Travel by Type
                    </h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="travelTypeChart" style="min-height:200px;width:100%;"></div>
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-2">
                        <span class="badge" style="background:#1a3a6b1a;color:#1a3a6b;font-size:.75rem;">
                            Foreign Official: {{ $totalForeignOff }}
                        </span>
                        <span class="badge" style="background:#006b3f1a;color:#006b3f;font-size:.75rem;">
                            Foreign Private: {{ $totalForeignPriv }}
                        </span>
                        <span class="badge" style="background:#c8a9511a;color:#78620a;font-size:.75rem;">
                            Local: {{ $totalLocal }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">

        {{-- Top countries --}}
        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-globe me-2" style="color:#1a3a6b;"></i>
                        Most Visited Countries
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($topCountries as $i => $c)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;
                            background:{{ $i === 0 ? '#1a3a6b' : '#e8f0fb' }};
                            color:{{ $i === 0 ? '#fff' : '#1a3a6b' }};
                            display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;font-weight:700;flex-shrink:0;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.85rem;">{{ $c['name'] }}</div>
                            <div class="progress mt-1" style="height:4px;">
                                <div class="progress-bar" style="width:{{ $topCountries[0]['count'] > 0 ? round(($c['count'] / $topCountries[0]['count']) * 100) : 0 }}%;background:#1a3a6b;"></div>
                            </div>
                        </div>
                        <span class="fw-semibold" style="font-size:.88rem;color:#1a3a6b;">
                            {{ $c['count'] }}
                        </span>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.85rem;">No foreign travel this year.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Top travellers --}}
        <div class="col-12 col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trophy me-2" style="color:#c8a951;"></i>
                        Most Travelled Staff — {{ $year }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Staff</th>
                                    <th class="d-none d-md-table-cell">Division</th>
                                    <th>Days Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topTravellers as $i => $staff)
                                <tr>
                                    <td>
                                        <span style="font-size:.78rem;font-weight:600;
                                            color:{{ $i === 0 ? '#c8a951' : ($i === 1 ? '#9ca3af' : ($i === 2 ? '#c8764a' : '#6c757d')) }};">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-medium" style="font-size:.84rem;">{{ $staff->full_name }}</div>
                                        <div class="text-muted" style="font-size:.74rem;">{{ $staff->role?->label }}</div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.82rem;">
                                        {{ $staff->department?->name ?? '—' }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="flex-grow-1">
                                                <div class="progress" style="height:5px;">
                                                    @php $pct = $staff->max_days_per_year > 0 ? min(100, round(($staff->days_used_this_year / $staff->max_days_per_year) * 100)) : 0; @endphp
                                                    <div class="progress-bar" style="width:{{ $pct }}%;
                                                        background:{{ $pct >= 80 ? '#bb0000' : '#1a3a6b' }};"></div>
                                                </div>
                                            </div>
                                            <span class="fw-semibold" style="font-size:.84rem;min-width:32px;
                                                color:{{ $pct >= 80 ? '#bb0000' : '#1a3a6b' }};">
                                                {{ $staff->days_used_this_year }}d
                                            </span>
                                        </div>
                                        <div class="text-muted" style="font-size:.72rem;">of {{ $staff->max_days_per_year }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No travel recorded yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">

        {{-- Currently out of office --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt me-2" style="color:#bb0000;"></i>
                        Currently Out of Office
                        @if($outOfOffice->count())
                        <span class="badge bg-danger ms-1" style="font-size:.7rem;">
                            {{ $outOfOffice->count() }}
                        </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0" style="max-height:320px;overflow-y:auto;">
                    @forelse($outOfOffice as $app)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:32px;height:32px;font-size:.68rem;flex-shrink:0;">
                            {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $app->user->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">
                                {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                &mdash; returns {{ $app->return_date->format('d M') }}
                                @if($app->user->department?->directorate)
                                    &mdash; {{ $app->user->department->directorate->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.85rem;">
                        <i class="bi bi-check-circle text-success me-1"></i>
                        No staff currently out of office.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Approaching limit --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2" style="color:#bb0000;"></i>
                        Approaching Annual Limit (≥80%)
                    </h5>
                </div>
                <div class="card-body p-0" style="max-height:320px;overflow-y:auto;">
                    @forelse($approachingLimit as $staff)
                    @php $pct = $staff->max_days_per_year > 0 ? min(100, round(($staff->days_used_this_year / $staff->max_days_per_year) * 100)) : 0; @endphp
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:32px;height:32px;font-size:.68rem;flex-shrink:0;
                            background:{{ $pct >= 100 ? '#bb0000' : '#c8a951' }};">
                            {{ strtoupper(substr($staff->first_name,0,1).substr($staff->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $staff->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">{{ $staff->department?->name ?? $staff->role?->label }}</div>
                            <div class="progress mt-1" style="height:4px;">
                                <div class="progress-bar" style="width:{{ $pct }}%;
                                    background:{{ $pct >= 100 ? '#bb0000' : '#c8a951' }};"></div>
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0">
                            <div class="fw-bold" style="font-size:.88rem;color:{{ $pct >= 100 ? '#bb0000' : '#c8a951' }};">
                                {{ $pct }}%
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                {{ $staff->days_used_this_year }}/{{ $staff->max_days_per_year }}d
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.85rem;">
                        <i class="bi bi-check-circle text-success me-1"></i>
                        No staff near their limit.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- By directorate --}}
    @if($byDirectorate->count())
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-building me-2" style="color:#1a3a6b;"></i>
                Applications by Directorate — {{ $year }}
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Directorate</th>
                            <th>Total</th>
                            <th class="d-none d-md-table-cell">Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byDirectorate as $row)
                        <tr>
                            <td style="font-size:.85rem;">{{ $row->directorate }}</td>
                            <td style="font-size:.85rem;font-weight:600;">{{ $row->total }}</td>
                            <td class="d-none d-md-table-cell" style="width:40%;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="flex-grow-1">
                                        <div class="progress" style="height:5px;">
                                            <div class="progress-bar" style="width:{{ $totalAppsYear > 0 ? round(($row->total / $totalAppsYear) * 100) : 0 }}%;background:#1a3a6b;"></div>
                                        </div>
                                    </div>
                                    <span class="text-muted" style="font-size:.78rem;min-width:36px;">
                                        {{ $totalAppsYear > 0 ? round(($row->total / $totalAppsYear) * 100) : 0 }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Recent applications --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>
                Recent Applications
            </h5>
            <div class="card-actions">
                <a href="{{ route('oversight.all-applications') }}"
                    class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:.78rem;">
                    View all
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Staff</th>
                            <th class="d-none d-md-table-cell">Destination</th>
                            <th class="d-none d-sm-table-cell">Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApps as $app)
                        <tr>
                            <td>
                                <a href="{{ route('travel.show', $app->id) }}"
                                    style="font-size:.83rem;color:#1a3a6b;font-weight:500;">
                                    {{ $app->reference_number }}
                                </a>
                                <div class="text-muted" style="font-size:.74rem;">
                                    {{ $app->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td style="font-size:.83rem;">{{ $app->user->full_name }}</td>
                            <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                {{ $app->country?->name ?? ($app->county?->name . ' County') ?? '—' }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge" style="font-size:.72rem;
                                    background:{{ $app->travel_type === 'foreign_official' ? '#1a3a6b1a' : ($app->travel_type === 'foreign_private' ? '#006b3f1a' : '#c8a9511a') }};
                                    color:{{ $app->travel_type === 'foreign_official' ? '#1a3a6b' : ($app->travel_type === 'foreign_private' ? '#006b3f' : '#78620a') }};">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor  = isDark ? '#9ca3af' : '#6c757d';
    const gridColor  = isDark ? '#374151' : '#f0f0f0';

    // Monthly applications chart
    const monthData = @json($chartMonths->pluck('total'));
    const monthLabels = @json($chartMonths->pluck('month'));

    new ApexCharts(document.querySelector('#appsMonthChart'), {
        series: [{ name: 'Applications', data: monthData }],
        chart: { type: 'bar', height: 240, toolbar: { show: false } },
        colors: ['#1a3a6b'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } },
        dataLabels: { enabled: false },
        xaxis: {
            categories: monthLabels,
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => Math.round(v) } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { y: { formatter: v => v + ' application(s)' } },
    }).render();

    // Travel type donut chart
    const typeValues = @json(array_values($travelByType));
    const typeLabels = @json(array_keys($travelByType));

    new ApexCharts(document.querySelector('#travelTypeChart'), {
        series: typeValues,
        chart: { type: 'donut', height: 200 },
        colors: ['#1a3a6b', '#006b3f', '#c8a951'],
        labels: typeLabels,
        plotOptions: { pie: { donut: { size: '70%',
            labels: { show: true, total: { show: true, label: 'Total',
                formatter: () => {{ $totalAppsYear }} + ''
            }}
        }}},
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 0 },
    }).render();
});
</script>
@endpush
