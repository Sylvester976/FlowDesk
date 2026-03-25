<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">HR Dashboard</h1>
            <p class="text-muted mb-0" style="font-size:.88rem;">
                Welcome, {{ auth()->user()->first_name }} &mdash; {{ now()->format('d M Y') }}
            </p>
        </div>
    </div>

    {{-- ── My Travel summary ──────────────────────────────── --}}
    @include('livewire.dashboard._my_travel_summary')

    {{-- ── Summary stats ───────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1" style="font-size:2rem;color:#1a3a6b;">{{ $totalStaff }}</div>
                    <div class="text-muted" style="font-size:.78rem;">Active Staff</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1"
                        style="font-size:2rem;color:{{ $outOfOffice->count() > 0 ? '#bb0000' : '#1a3a6b' }};">
                        {{ $outOfOffice->count() }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Out of Office</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1"
                        style="font-size:2rem;color:{{ $pendingPostTrip->count() > 0 ? '#c8a951' : '#1a3a6b' }};">
                        {{ $pendingPostTrip->count() }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Pending Review</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1"
                        style="font-size:2rem;color:{{ $overdueUploads->count() > 0 ? '#bb0000' : '#006b3f' }};">
                        {{ $overdueUploads->count() }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">Overdue Uploads</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Chart row ───────────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2" style="color:#1a3a6b;"></i>
                        Applications by Month — {{ now()->year }}
                    </h5>
                </div>
                <div class="card-body">
                    <div id="hrMonthChart" style="min-height:220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2" style="color:#1a3a6b;"></i>
                        This Month by Type
                    </h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="hrTypeChart" style="min-height:180px;width:100%;"></div>
                    <div class="d-flex flex-column gap-1 mt-2 w-100" style="font-size:.78rem;">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Foreign Official</span>
                            <strong>{{ $appsThisMonth['foreign_official'] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Foreign Private</span>
                            <strong>{{ $appsThisMonth['foreign_private'] ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Local</span>
                            <strong>{{ $appsThisMonth['local'] ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">

        {{-- Most visited countries --}}
        <div class="col-12 col-lg-4">
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
                        <div style="width:26px;height:26px;border-radius:50%;
                            background:{{ $i === 0 ? '#1a3a6b' : '#e8f0fb' }};
                            color:{{ $i === 0 ? '#fff' : '#1a3a6b' }};
                            display:flex;align-items:center;justify-content:center;
                            font-size:.7rem;font-weight:700;flex-shrink:0;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $c['name'] }}</div>
                            <div class="progress mt-1" style="height:3px;">
                                <div class="progress-bar" style="width:{{ $topCountries[0]['count'] > 0 ? round(($c['count'] / $topCountries[0]['count']) * 100) : 0 }}%;background:#1a3a6b;"></div>
                            </div>
                        </div>
                        <span class="fw-semibold" style="font-size:.85rem;color:#1a3a6b;">
                            {{ $c['count'] }}
                        </span>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">No foreign travel yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Most travelled staff --}}
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trophy me-2" style="color:#c8a951;"></i>
                        Most Travelled Staff
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
                                    <th>Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topTravellers as $i => $staff)
                                <tr>
                                    <td style="font-size:.78rem;font-weight:600;
                                        color:{{ $i === 0 ? '#c8a951' : ($i === 1 ? '#9ca3af' : ($i === 2 ? '#c8764a' : '#6c757d')) }};">
                                        {{ $i + 1 }}
                                    </td>
                                    <td>
                                        <div class="fw-medium" style="font-size:.84rem;">{{ $staff->full_name }}</div>
                                        <div class="text-muted" style="font-size:.74rem;">{{ $staff->role?->label }}</div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.82rem;">
                                        {{ $staff->department?->name ?? '—' }}
                                    </td>
                                    <td>
                                        @php $pct = $staff->max_days_per_year > 0 ? min(100, round(($staff->days_used_this_year / $staff->max_days_per_year) * 100)) : 0; @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="flex-grow-1 d-none d-sm-block">
                                                <div class="progress" style="height:4px;">
                                                    <div class="progress-bar" style="width:{{ $pct }}%;
                                                        background:{{ $pct >= 80 ? '#bb0000' : '#1a3a6b' }};"></div>
                                                </div>
                                            </div>
                                            <span class="fw-semibold" style="font-size:.84rem;
                                                color:{{ $pct >= 80 ? '#bb0000' : '#1a3a6b' }};">
                                                {{ $staff->days_used_this_year }}d
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No travel data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Currently out of office --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt me-2" style="color:#bb0000;"></i>
                        Out of Office
                        @if($outOfOffice->count())
                        <span class="badge bg-danger ms-1" style="font-size:.7rem;">{{ $outOfOffice->count() }}</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0" style="max-height:280px;overflow-y:auto;">
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
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                {{ $app->user->department?->name ?? '—' }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                        <i class="bi bi-check-circle text-success me-1"></i> Nobody out right now.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Overdue uploads --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"
                            style="color:{{ $overdueUploads->count() > 0 ? '#bb0000' : '#6c757d' }};"></i>
                        Overdue Post-Trip Uploads
                        @if($overdueUploads->count())
                        <span class="badge bg-danger ms-1" style="font-size:.7rem;">{{ $overdueUploads->count() }}</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0" style="max-height:280px;overflow-y:auto;">
                    @forelse($overdueUploads as $app)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:32px;height:32px;font-size:.68rem;flex-shrink:0;background:#bb0000;">
                            {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $app->user->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">
                                {{ $app->reference_number }} &mdash;
                                returned {{ $app->return_date->format('d M Y') }}
                                <span class="text-danger">({{ $app->return_date->diffForHumans() }})</span>
                            </div>
                        </div>
                        <a href="{{ route('travel.show', $app->id) }}"
                            class="btn btn-sm btn-outline-danger py-0 px-2"
                            style="font-size:.74rem;">View</a>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                        <i class="bi bi-check-circle text-success me-1"></i> All caught up.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- By directorate --}}
    @if($appsByDirectorate->count())
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-building me-2" style="color:#1a3a6b;"></i>
                Applications by Directorate
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Directorate</th>
                            <th>Total</th>
                            <th class="d-none d-md-table-cell">Breakdown</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxDir = $appsByDirectorate->max('total'); @endphp
                        @foreach($appsByDirectorate as $row)
                        <tr>
                            <td style="font-size:.84rem;">{{ $row->directorate }}</td>
                            <td style="font-size:.84rem;font-weight:600;">{{ $row->total }}</td>
                            <td class="d-none d-md-table-cell" style="width:45%;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="flex-grow-1">
                                        <div class="progress" style="height:5px;">
                                            <div class="progress-bar" style="width:{{ $maxDir > 0 ? round(($row->total / $maxDir) * 100) : 0 }}%;background:#1a3a6b;"></div>
                                        </div>
                                    </div>
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

</div>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#9ca3af' : '#6c757d';
    const gridColor = isDark ? '#374151' : '#f0f0f0';

    // Monthly chart
    const raw = @json($appsByMonth);
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const data   = months.map((_, i) => raw[i] || 0);

    new ApexCharts(document.querySelector('#hrMonthChart'), {
        series: [{ name: 'Applications', data }],
        chart: { type: 'area', height: 220, toolbar: { show: false }, sparkline: { enabled: false } },
        colors: ['#1a3a6b'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: .4, opacityTo: .05 } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: months,
            labels: { style: { colors: textColor, fontSize: '11px' } },
            axisBorder: { show: false }, axisTicks: { show: false },
        },
        yaxis: { labels: { style: { colors: textColor }, formatter: v => Math.round(v) } },
        grid: { borderColor: gridColor, strokeDashArray: 4 },
        tooltip: { y: { formatter: v => v + ' application(s)' } },
    }).render();

    // Type donut
    const typeData   = [{{ $appsThisMonth['foreign_official'] ?? 0 }}, {{ $appsThisMonth['foreign_private'] ?? 0 }}, {{ $appsThisMonth['local'] ?? 0 }}];
    const typeLabels = ['Foreign Official', 'Foreign Private', 'Local'];

    new ApexCharts(document.querySelector('#hrTypeChart'), {
        series: typeData,
        chart: { type: 'donut', height: 180 },
        colors: ['#1a3a6b', '#006b3f', '#c8a951'],
        labels: typeLabels,
        plotOptions: { pie: { donut: { size: '65%' } } },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 0 },
    }).render();
});
</script>
@endpush
