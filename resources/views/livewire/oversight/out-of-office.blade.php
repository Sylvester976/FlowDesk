<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Out of Office</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Out of Office</span>
            </nav>
        </div>
        <div class="page-header-actions d-flex gap-2 align-items-center">
            <select wire:model.live="filterDirectorate" class="form-select form-select-sm">
                <option value="">All Directorates</option>
                @foreach($directorates as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterType" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="foreign_official">Foreign Official</option>
                <option value="foreign_private">Foreign Private</option>
                <option value="local">Local</option>
            </select>
        </div>
    </div>

    {{-- Currently out --}}
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-geo-alt me-2" style="color:#bb0000;"></i>
                Currently Travelling
                @if($current->count())
                <span class="badge bg-danger ms-1" style="font-size:.72rem;">{{ $current->count() }}</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @forelse($current as $app)
            <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}
                flex-wrap">
                <div class="user-initials-avatar" style="width:38px;height:38px;font-size:.75rem;flex-shrink:0;">
                    {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="font-size:.88rem;">{{ $app->user->full_name }}</div>
                    <div class="text-muted" style="font-size:.76rem;">
                        {{ $app->user->role?->label }}
                        @if($app->user->department?->directorate)
                            &mdash; {{ $app->user->department->directorate->name }}
                        @endif
                    </div>
                </div>
                <div class="text-center d-none d-sm-block">
                    <div class="fw-medium" style="font-size:.85rem;">
                        {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                    </div>
                    <div class="text-muted" style="font-size:.74rem;">{{ $app->getTravelTypeLabel() }}</div>
                </div>
                <div class="text-center">
                    <div style="font-size:.82rem;">
                        {{ $app->departure_date->format('d M') }}
                        → <strong>{{ $app->return_date->format('d M Y') }}</strong>
                    </div>
                    <div style="font-size:.74rem;">
                        @if($app->return_date->isPast())
                            <span class="text-danger">Overdue return</span>
                        @else
                            <span class="text-muted">Returns {{ $app->return_date->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('travel.show', $app->id) }}"
                    class="btn btn-sm btn-outline-secondary py-0 px-2 flex-shrink-0"
                    style="font-size:.74rem;">View</a>
            </div>
            @empty
            <div class="p-5 text-center text-muted">
                <i class="bi bi-check-circle fs-2 d-block mb-2 text-success"></i>
                No staff currently travelling.
            </div>
            @endforelse
        </div>
    </div>

    <div class="row g-3">

        {{-- Departing soon --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-airplane-engines me-2" style="color:#1a3a6b;"></i>
                        Departing in Next 7 Days
                        @if($departingSoon->count())
                        <span class="badge bg-primary ms-1" style="font-size:.72rem;">
                            {{ $departingSoon->count() }}
                        </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($departingSoon as $app)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                            {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $app->user->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">
                                {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0">
                            <div class="fw-medium" style="font-size:.82rem;color:#1a3a6b;">
                                {{ $app->departure_date->format('d M Y') }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                {{ $app->departure_date->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                        No departures in the next 7 days.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Overdue returns --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"
                            style="color:{{ $overdue->count() ? '#bb0000' : '#6c757d' }};"></i>
                        Overdue Post-Trip Uploads
                        @if($overdue->count())
                        <span class="badge bg-danger ms-1" style="font-size:.72rem;">
                            {{ $overdue->count() }}
                        </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($overdue as $app)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="user-initials-avatar" style="width:34px;height:34px;font-size:.7rem;
                            flex-shrink:0;background:#bb0000;">
                            {{ strtoupper(substr($app->user->first_name,0,1).substr($app->user->last_name,0,1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium" style="font-size:.84rem;">{{ $app->user->full_name }}</div>
                            <div class="text-muted" style="font-size:.74rem;">
                                {{ $app->reference_number }} &mdash;
                                {{ $app->country?->name ?? ($app->county?->name . ' County') }}
                            </div>
                        </div>
                        <div class="text-end flex-shrink-0">
                            <div class="text-danger fw-medium" style="font-size:.82rem;">
                                {{ $app->return_date->format('d M Y') }}
                            </div>
                            <div class="text-danger" style="font-size:.72rem;">
                                {{ $app->return_date->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                        <i class="bi bi-check-circle text-success me-1"></i>
                        No overdue returns.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
</div>
