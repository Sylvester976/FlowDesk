<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Welcome, {{ auth()->user()->first_name }}</h1>
            <p class="text-muted mb-0" style="font-size:.88rem;">
                {{ auth()->user()->jobTitle?->name ?? auth()->user()->role?->label }}
                @if(auth()->user()->department)
                    &mdash; {{ auth()->user()->department->name }}
                @endif
            </p>
        </div>
        @if($canApply)
        <div class="page-header-actions">
            <a href="{{ route('travel.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> New Application
            </a>
        </div>
        @endif
    </div>

    {{-- ── Days Docket ────────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;">Days Used</div>
                            <div class="fw-bold" style="font-size:2rem;color:#1a3a6b;line-height:1;">{{ $daysUsed }}</div>
                            <div class="text-muted" style="font-size:.78rem;">of {{ $daysMax }} days</div>
                        </div>
                        <div style="width:48px;height:48px;border-radius:12px;background:#e8f0fb;
                            display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-calendar-check" style="color:#1a3a6b;font-size:1.2rem;"></i>
                        </div>
                    </div>
                    <div class="progress" style="height:6px;border-radius:4px;">
                        <div class="progress-bar" role="progressbar"
                            style="width:{{ $daysPercent }}%;
                                background:{{ $daysPercent >= 80 ? '#bb0000' : ($daysPercent >= 60 ? '#c8a951' : '#006b3f') }};"
                            aria-valuenow="{{ $daysPercent }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span style="font-size:.74rem;color:{{ $daysPercent >= 80 ? '#bb0000' : '#6c757d' }};">
                            {{ $daysPercent }}% used
                        </span>
                        <span style="font-size:.74rem;color:#006b3f;">
                            {{ $daysRemaining }} remaining
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold mb-1" style="font-size:2rem;color:#006b3f;">
                        {{ $appsByType['foreign_official'] ?? 0 }}
                    </div>
                    <div class="text-muted" style="font-size:.8rem;">Foreign Official</div>
                    <div class="text-muted" style="font-size:.74rem;">this year</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="fw-bold mb-1" style="font-size:2rem;color:#c8a951;">
                        {{ ($appsByType['foreign_private'] ?? 0) + ($appsByType['local'] ?? 0) }}
                    </div>
                    <div class="text-muted" style="font-size:.8rem;">Private + Local</div>
                    <div class="text-muted" style="font-size:.74rem;">this year</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">

            {{-- Active application --}}
            @if($activeApp)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>Active Application
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                        <div>
                            <div class="fw-semibold mb-1">{{ $activeApp->reference_number }}</div>
                            <div class="text-muted mb-2" style="font-size:.83rem;">
                                {{ $activeApp->country?->name ?? ($activeApp->county?->name . ' County') }}
                                &mdash;
                                {{ $activeApp->departure_date->format('d M Y') }}
                                → {{ $activeApp->return_date->format('d M Y') }}
                            </div>
                            <span class="badge bg-{{ $activeApp->getStatusColor() }}-subtle
                                text-{{ $activeApp->getStatusColor() }}
                                border border-{{ $activeApp->getStatusColor() }}-subtle">
                                {{ $activeApp->getStatusLabel() }}
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            @if($activeApp->status === 'returned')
                            <a href="{{ route('travel.edit', $activeApp->id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil me-1"></i> Revise
                            </a>
                            @endif
                            @if($activeApp->status === 'pending_uploads' && $activeApp->return_date->isPast())
                            <a href="{{ route('travel.post-trip') }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-upload me-1"></i> Upload
                            </a>
                            @endif
                            <a href="{{ route('travel.show', $activeApp->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-3 border-0" style="background:#e8f5ee;">
                <div class="card-body py-3 d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="fw-medium" style="color:#006b3f;">No active application</div>
                        <div class="text-muted" style="font-size:.82rem;">
                            You are free to submit a new travel application.
                        </div>
                    </div>
                    <a href="{{ route('travel.create') }}" class="btn btn-sm btn-success flex-shrink-0">
                        <i class="bi bi-plus-lg me-1"></i> Apply Now
                    </a>
                </div>
            </div>
            @endif

            {{-- Recent applications --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>
                        Recent Applications
                    </h5>
                    <div class="card-actions">
                        <a href="{{ route('travel.index') }}" class="btn btn-sm btn-outline-primary py-0 px-2"
                            style="font-size:.78rem;">View all</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($recentApps as $app)
                    <a href="{{ route('travel.show', $app->id) }}"
                        class="d-flex align-items-center gap-3 p-3 text-decoration-none
                        {{ !$loop->last ? 'border-bottom' : '' }}"
                        style="color:var(--bs-body-color);"
                        onmouseover="this.style.background='var(--bs-tertiary-bg)'"
                        onmouseout="this.style.background='transparent'">
                        <div style="width:36px;height:36px;border-radius:8px;flex-shrink:0;
                            display:flex;align-items:center;justify-content:center;
                            background:{{ $app->travel_type === 'foreign_official' ? '#e8f0fb' : ($app->travel_type === 'foreign_private' ? '#e8f5ee' : '#fff8e1') }};">
                            <i class="bi bi-airplane"
                                style="font-size:.9rem;color:{{ $app->travel_type === 'foreign_official' ? '#1a3a6b' : ($app->travel_type === 'foreign_private' ? '#006b3f' : '#c8a951') }};"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.85rem;">
                                {{ $app->reference_number }}
                                <span class="text-muted fw-normal ms-1" style="font-size:.78rem;">
                                    {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                                </span>
                            </div>
                            <div class="text-muted" style="font-size:.76rem;">
                                {{ $app->departure_date->format('d M Y') }} →
                                {{ $app->return_date->format('d M Y') }}
                            </div>
                        </div>
                        <span class="badge bg-{{ $app->getStatusColor() }}-subtle
                            text-{{ $app->getStatusColor() }}
                            border border-{{ $app->getStatusColor() }}-subtle"
                            style="font-size:.72rem;">
                            {{ $app->getStatusLabel() }}
                        </span>
                    </a>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.85rem;">
                        No applications yet.
                        <a href="{{ route('travel.create') }}" class="d-block mt-1">Submit your first</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            {{-- Countries visited --}}
            @if($countriesVisited->count())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-globe me-2" style="color:#1a3a6b;"></i>Countries Visited
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($countriesVisited as $i => $c)
                    <div class="d-flex align-items-center gap-3 p-3 {{ $i < $countriesVisited->count() - 1 ? 'border-bottom' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;background:#1a3a6b;
                            color:#fff;display:flex;align-items:center;justify-content:center;
                            font-size:.72rem;font-weight:700;flex-shrink:0;">
                            {{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1 fw-medium" style="font-size:.85rem;">
                            {{ $c['name'] }}
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle"
                            style="font-size:.75rem;">
                            {{ $c['count'] }} trip{{ $c['count'] > 1 ? 's' : '' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Quick links --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning me-2" style="color:#1a3a6b;"></i>Quick Links
                    </h5>
                </div>
                <div class="card-body p-0">
                    <a href="{{ route('travel.index') }}"
                        class="d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none"
                        style="color:var(--bs-body-color);">
                        <i class="bi bi-list-ul text-primary"></i>
                        <span style="font-size:.85rem;">My Applications</span>
                        <i class="bi bi-chevron-right ms-auto text-muted" style="font-size:.75rem;"></i>
                    </a>
                    <a href="{{ route('travel.post-trip') }}"
                        class="d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none"
                        style="color:var(--bs-body-color);">
                        <i class="bi bi-upload text-warning"></i>
                        <span style="font-size:.85rem;">Post-Trip Upload</span>
                        <i class="bi bi-chevron-right ms-auto text-muted" style="font-size:.75rem;"></i>
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="d-flex align-items-center gap-3 p-3 text-decoration-none"
                        style="color:var(--bs-body-color);">
                        <i class="bi bi-bell text-info"></i>
                        <span style="font-size:.85rem;">Notifications</span>
                        <i class="bi bi-chevron-right ms-auto text-muted" style="font-size:.75rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
