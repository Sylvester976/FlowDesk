@php
    $myUser        = auth()->user();
    $daysUsed      = $myUser->days_used_this_year;
    $daysMax       = $myUser->max_days_per_year;
    $daysRemaining = $myUser->days_remaining;
    $daysPercent   = $daysMax > 0 ? min(100, round(($daysUsed / $daysMax) * 100)) : 0;

    $myActiveApp = \App\Models\TravelApplication::where('user_id', $myUser->id)
        ->whereIn('status', ['submitted', 'pending_concurrence', 'returned', 'pending_uploads'])
        ->with(['country', 'county'])
        ->latest()
        ->first();

    $myCanApply = ! $myActiveApp && ! $myUser->hasPendingPostTripUploads();

    $myTotalApps = \App\Models\TravelApplication::where('user_id', $myUser->id)
        ->whereYear('created_at', now()->year)
        ->count();

    $myCountries = \App\Models\TravelApplication::where('user_id', $myUser->id)
        ->where('status', 'closed')
        ->whereNotNull('country_id')
        ->whereYear('created_at', now()->year)
        ->distinct('country_id')
        ->count('country_id');
@endphp

<div class="card mb-3" style="border-left:4px solid #1a3a6b;">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3a6b08,#006b3f05);">
        <h5 class="card-title mb-0" style="color:#1a3a6b;">
            <i class="bi bi-person-circle me-2"></i>My Travel — {{ now()->year }}
        </h5>
        <div class="card-actions">
            @if($myCanApply)
            <a href="{{ route('travel.create') }}" class="btn btn-sm btn-primary py-0 px-2"
                style="font-size:.78rem;">
                <i class="bi bi-plus-lg me-1"></i> Apply
            </a>
            @endif
            <a href="{{ route('travel.index') }}" class="btn btn-sm btn-outline-secondary py-0 px-2 ms-1"
                style="font-size:.78rem;">
                View all
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-center">

            {{-- Days docket --}}
            <div class="col-12 col-sm-5 col-lg-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:44px;height:44px;border-radius:12px;background:#e8f0fb;
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-calendar-check" style="color:#1a3a6b;font-size:1.1rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:.74rem;color:var(--bs-secondary-color);">Days Docket</span>
                            <span style="font-size:.74rem;
                                color:{{ $daysPercent >= 80 ? '#bb0000' : '#006b3f' }};">
                                {{ $daysRemaining }} remaining
                            </span>
                        </div>
                        <div class="progress" style="height:6px;border-radius:4px;">
                            <div class="progress-bar" role="progressbar"
                                style="width:{{ $daysPercent }}%;
                                    background:{{ $daysPercent >= 100 ? '#bb0000' : ($daysPercent >= 80 ? '#c8a951' : '#006b3f') }};">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span style="font-size:.72rem;color:var(--bs-secondary-color);">
                                {{ $daysUsed }} used
                            </span>
                            <span style="font-size:.72rem;color:var(--bs-secondary-color);">
                                {{ $daysMax }} max
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="col-auto d-none d-sm-block">
                <div style="width:1px;height:48px;background:var(--bs-border-color);"></div>
            </div>

            {{-- Quick stats --}}
            <div class="col-12 col-sm">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="text-center p-2 rounded" style="background:var(--bs-tertiary-bg);">
                            <div class="fw-bold" style="font-size:1.3rem;color:#1a3a6b;line-height:1.1;">
                                {{ $myTotalApps }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">Apps</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-2 rounded" style="background:var(--bs-tertiary-bg);">
                            <div class="fw-bold" style="font-size:1.3rem;color:#006b3f;line-height:1.1;">
                                {{ $myCountries }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">Countries</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-2 rounded" style="background:var(--bs-tertiary-bg);">
                            <div class="fw-bold" style="font-size:1.3rem;line-height:1.1;
                                color:{{ $daysPercent >= 80 ? '#bb0000' : '#1a3a6b' }};">
                                {{ $daysPercent }}%
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">Used</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active app (if any) --}}
            @if($myActiveApp)
            <div class="col-auto d-none d-lg-block">
                <div style="width:1px;height:48px;background:var(--bs-border-color);"></div>
            </div>
            <div class="col-12 col-lg">
                <div class="d-flex align-items-center gap-2 p-2 rounded"
                    style="background:var(--bs-tertiary-bg);">
                    <div class="flex-grow-1">
                        <div class="fw-medium" style="font-size:.82rem;">
                            {{ $myActiveApp->reference_number }}
                            <span class="text-muted fw-normal ms-1" style="font-size:.76rem;">
                                {{ $myActiveApp->country?->name ?? ($myActiveApp->county?->name . ' County') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <span class="badge bg-{{ $myActiveApp->getStatusColor() }}-subtle
                                text-{{ $myActiveApp->getStatusColor() }}
                                border border-{{ $myActiveApp->getStatusColor() }}-subtle"
                                style="font-size:.7rem;">
                                {{ $myActiveApp->getStatusLabel() }}
                            </span>
                            <span class="text-muted" style="font-size:.72rem;">
                                {{ $myActiveApp->departure_date->format('d M') }} →
                                {{ $myActiveApp->return_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        @if($myActiveApp->status === 'returned')
                        <a href="{{ route('travel.edit', $myActiveApp->id) }}"
                            class="btn btn-sm btn-warning py-0 px-2" style="font-size:.74rem;">
                            Revise
                        </a>
                        @endif
                        @if($myActiveApp->status === 'pending_uploads' && $myActiveApp->return_date->isPast())
                        <a href="{{ route('travel.post-trip') }}"
                            class="btn btn-sm btn-warning py-0 px-2" style="font-size:.74rem;">
                            Upload
                        </a>
                        @endif
                        <a href="{{ route('travel.show', $myActiveApp->id) }}"
                            class="btn btn-sm btn-outline-primary py-0 px-2"
                            style="font-size:.74rem;">View</a>
                    </div>
                </div>
            </div>
            @else
            <div class="col-auto d-none d-lg-block">
                <div style="width:1px;height:48px;background:var(--bs-border-color);"></div>
            </div>
            <div class="col-12 col-lg-auto">
                <div class="d-flex align-items-center gap-2 text-muted" style="font-size:.82rem;">
                    <i class="bi bi-check-circle text-success"></i>
                    No active application.
                    @if($myCanApply)
                    <a href="{{ route('travel.create') }}" style="color:#1a3a6b;font-size:.8rem;">
                        Apply now →
                    </a>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
