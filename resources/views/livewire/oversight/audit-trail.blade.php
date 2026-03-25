<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Audit Trail</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Audit Trail</span>
            </nav>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <ul class="nav nav-pills gap-1">
                <li class="nav-item">
                    <button wire:click="$set('tab', 'applications')"
                        class="nav-link {{ $tab === 'applications' ? 'active' : '' }} py-1 px-3"
                        style="font-size:.84rem;">
                        <i class="bi bi-airplane me-1"></i> Application Logs
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="$set('tab', 'auth')"
                        class="nav-link {{ $tab === 'auth' ? 'active' : '' }} py-1 px-3"
                        style="font-size:.84rem;">
                        <i class="bi bi-shield-lock me-1"></i> Auth Logs
                    </button>
                </li>
            </ul>
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
                            class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterAction" class="form-select form-select-sm">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                        <option value="{{ $action }}">{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
                        @endforeach
                    </select>
                </div>
                @if($tab === 'applications')
                <div class="col-6 col-sm-auto">
                    <select wire:model.live="filterUser" class="form-select form-select-sm">
                        <option value="">All Users</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-6 col-sm-auto">
                    <input type="date" wire:model.live="dateFrom"
                        class="form-control form-control-sm" title="From date">
                </div>
                <div class="col-6 col-sm-auto">
                    <input type="date" wire:model.live="dateTo"
                        class="form-control form-control-sm" title="To date">
                </div>
                <div class="col-auto">
                    <button wire:click="$set('search', ''); $set('filterAction', '');
                        $set('filterUser', ''); $set('dateFrom', ''); $set('dateTo', '')"
                        class="btn btn-sm btn-outline-secondary">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Logs --}}
    <div class="card">
        <div class="card-body p-0">
            @if($tab === 'applications')
            {{-- Application logs --}}
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Action</th>
                            <th>Application</th>
                            <th>User</th>
                            <th class="d-none d-md-table-cell">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td style="font-size:.78rem;white-space:nowrap;">
                                <div>{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-muted">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                @php
                                    $actionColor = match($log->action) {
                                        'submitted','resubmitted'  => ['bg' => '#e8f0fb', 'text' => '#1a3a6b'],
                                        'concurred'                => ['bg' => '#e8f5ee', 'text' => '#006b3f'],
                                        'not_concurred'            => ['bg' => '#ffebee', 'text' => '#bb0000'],
                                        'returned'                 => ['bg' => '#fff8e1', 'text' => '#78620a'],
                                        'closed'                   => ['bg' => '#f0f0f0', 'text' => '#555'],
                                        'post_trip_submitted'      => ['bg' => '#e8f5ee', 'text' => '#006b3f'],
                                        default                    => ['bg' => '#f8f9fa', 'text' => '#495057'],
                                    };
                                @endphp
                                <span class="badge" style="font-size:.72rem;
                                    background:{{ $actionColor['bg'] }};color:{{ $actionColor['text'] }};">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                @if($log->travelApplication)
                                <a href="{{ route('travel.show', $log->travel_application_id) }}"
                                    style="font-size:.82rem;color:#1a3a6b;font-weight:500;">
                                    {{ $log->travelApplication->reference_number }}
                                </a>
                                @else
                                <span class="text-muted" style="font-size:.8rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size:.82rem;">
                                {{ $log->user?->full_name ?? 'System' }}
                            </td>
                            <td class="d-none d-md-table-cell text-muted" style="font-size:.8rem;">
                                {{ $log->description ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-2 d-block mb-2"></i>
                                No logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @else
            {{-- Auth logs --}}
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Action</th>
                            <th>User</th>
                            <th class="d-none d-sm-table-cell">IP Address</th>
                            <th class="d-none d-md-table-cell">User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td style="font-size:.78rem;white-space:nowrap;">
                                <div>{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-muted">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                @php
                                    $authColor = match($log->action) {
                                        'login'           => ['bg' => '#e8f5ee', 'text' => '#006b3f'],
                                        'logout'          => ['bg' => '#f0f0f0', 'text' => '#555'],
                                        'failed_login'    => ['bg' => '#ffebee', 'text' => '#bb0000'],
                                        'otp_sent'        => ['bg' => '#e8f0fb', 'text' => '#1a3a6b'],
                                        'otp_verified'    => ['bg' => '#e8f5ee', 'text' => '#006b3f'],
                                        'password_changed'=> ['bg' => '#fff8e1', 'text' => '#78620a'],
                                        default           => ['bg' => '#f8f9fa', 'text' => '#495057'],
                                    };
                                @endphp
                                <span class="badge" style="font-size:.72rem;
                                    background:{{ $authColor['bg'] }};color:{{ $authColor['text'] }};">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-medium" style="font-size:.82rem;">
                                    {{ $log->user?->full_name ?? 'Unknown' }}
                                </div>
                                <div class="text-muted" style="font-size:.72rem;">
                                    {{ $log->user?->email }}
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell" style="font-size:.8rem;font-family:monospace;">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                            <td class="d-none d-md-table-cell text-muted"
                                style="font-size:.74rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $log->user_agent ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-shield-lock fs-2 d-block mb-2"></i>
                                No auth logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        @if($logs->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }}
            </div>
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
</div>
