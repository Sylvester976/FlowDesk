<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">User Service Sync</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <a href="{{ route('admin.staff.index') }}" class="breadcrumb-item">Administration</a>
                <span class="breadcrumb-item active">User Service Sync</span>
            </nav>
        </div>
        <div class="page-header-actions d-flex gap-2">
            <button wire:click="runDeltaSync"
                class="btn btn-sm btn-outline-primary"
                @if(!$isHealthy || $syncing) disabled @endif
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="runDeltaSync">
                    <i class="bi bi-arrow-repeat me-1"></i> Delta Sync
                </span>
                <span wire:loading wire:target="runDeltaSync">
                    <span class="spinner-border spinner-border-sm me-1"></span> Syncing...
                </span>
            </button>
            <button wire:click="runFullSync"
                wire:confirm="Run a full bidirectional sync? This may take a while."
                class="btn btn-sm btn-primary"
                @if(!$isHealthy || $syncing) disabled @endif
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="runFullSync">
                    <i class="bi bi-arrow-left-right me-1"></i> Full Sync
                </span>
                <span wire:loading wire:target="runFullSync">
                    <span class="spinner-border spinner-border-sm me-1"></span> Running...
                </span>
            </button>
        </div>
    </div>

    {{-- Connection status --}}
    <div class="card mb-3 border-0"
        style="background:{{ $isHealthy ? '#e8f5ee' : ($isConfigured ? '#fff8e1' : '#ffebee') }};
               border-left:4px solid {{ $isHealthy ? '#006b3f' : ($isConfigured ? '#c8a951' : '#bb0000') }} !important;">
        <div class="card-body py-2 d-flex align-items-center gap-3">
            <i class="bi bi-{{ $isHealthy ? 'check-circle-fill text-success' : ($isConfigured ? 'exclamation-triangle text-warning' : 'x-circle-fill text-danger') }}"
                style="font-size:1.1rem;"></i>
            <div>
                <div class="fw-medium" style="font-size:.88rem;">
                    @if($isHealthy) User Service Connected
                    @elseif($isConfigured) User Service Configured but Unreachable
                    @else User Service Not Configured
                    @endif
                </div>
                <div class="text-muted" style="font-size:.78rem;">
                    @if(!$isConfigured)
                        Set <code>USER_SERVICE_URL</code> and <code>USER_SERVICE_API_KEY</code> in <code>.env</code>
                    @elseif(!$isHealthy)
                        Check that the User Service is running. Falling back to local auth.
                    @else
                        All systems operational. Local fallback is active.
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Summary stats --}}
    <div class="row g-3 mb-3">
        @foreach([
            ['label' => 'Total Staff',   'key' => 'total',    'color' => '#1a3a6b', 'bg' => '#e8f0fb'],
            ['label' => 'Synced',        'key' => 'synced',   'color' => '#006b3f', 'bg' => '#e8f5ee'],
            ['label' => 'Pending',       'key' => 'pending',  'color' => '#c8a951', 'bg' => '#fff8e1'],
            ['label' => 'Unlinked',      'key' => 'unlinked', 'color' => '#bb0000', 'bg' => '#ffebee'],
            ['label' => 'Conflicts',     'key' => 'conflict', 'color' => '#bb0000', 'bg' => '#ffebee'],
        ] as $stat)
        <div class="col-6 col-md">
            <div class="card" style="cursor:pointer;"
                wire:click="$set('filterStatus', '{{ $stat['key'] }}')">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1"
                        style="font-size:1.8rem;color:{{ $stat['color'] }};">
                        {{ $summary[$stat['key']] }}
                    </div>
                    <div class="text-muted" style="font-size:.78rem;">{{ $stat['label'] }}</div>
                </div>
                @if($filterStatus === $stat['key'])
                <div style="height:2px;background:{{ $stat['color'] }};"></div>
                @endif
            </div>
        </div>
        @endforeach
        {{-- Show all --}}
        <div class="col-6 col-md">
            <div class="card" style="cursor:pointer;" wire:click="$set('filterStatus', 'all')">
                <div class="card-body py-3 text-center">
                    <div class="fw-bold mb-1" style="font-size:1.8rem;color:#6c757d;">All</div>
                    <div class="text-muted" style="font-size:.78rem;">Show All</div>
                </div>
                @if($filterStatus === 'all')
                <div style="height:2px;background:#6c757d;"></div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8">

            {{-- Staff sync table --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people me-2" style="color:#1a3a6b;"></i>
                        Staff Sync Status
                        @if($filterStatus !== 'all')
                            <span class="badge bg-secondary ms-1" style="font-size:.72rem;">
                                {{ ucfirst($filterStatus) }}
                            </span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th class="d-none d-md-table-cell">PF Number</th>
                                    <th>Sync Status</th>
                                    <th class="d-none d-sm-table-cell">Last Synced</th>
                                    @if($isHealthy)
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staff as $user)
                                <tr wire:key="sync-{{ $user->id }}">
                                    <td>
                                        <div class="fw-medium" style="font-size:.84rem;">
                                            {{ $user->full_name }}
                                        </div>
                                        <div class="text-muted" style="font-size:.74rem;">
                                            {{ $user->role?->label }}
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell"
                                        style="font-size:.82rem;font-family:monospace;">
                                        {{ $user->pf_number }}
                                    </td>
                                    <td>
                                        @php
                                            $sc = match($user->sync_status) {
                                                'synced'   => ['success', 'check-circle'],
                                                'pending'  => ['warning',   'clock'],
                                                'conflict' => ['danger',    'exclamation-triangle'],
                                                default    => ['secondary', 'dash-circle'],
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $sc[0] }}-subtle
                                            text-{{ $sc[0] }} border border-{{ $sc[0] }}-subtle"
                                            style="font-size:.72rem;">
                                            <i class="bi bi-{{ $sc[1] }} me-1"></i>
                                            {{ $user->user_service_id ? ucfirst($user->sync_status) : 'Unlinked' }}
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-muted"
                                        style="font-size:.78rem;">
                                        {{ $user->last_synced_at?->diffForHumans() ?? 'Never' }}
                                    </td>
                                    @if($isHealthy)
                                    <td>
                                        <button wire:click="syncUser({{ $user->id }})"
                                            class="btn btn-sm btn-outline-primary py-0 px-2"
                                            style="font-size:.74rem;">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($staff->hasPages())
                <div class="card-footer">{{ $staff->links() }}</div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-4">
            {{-- Recent sync logs --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2" style="color:#1a3a6b;"></i>
                        Recent Sync Runs
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($logs as $log)
                    <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="fw-medium" style="font-size:.84rem;">
                                {{ ucfirst($log->sync_type) }} Sync
                            </span>
                            <span class="text-muted" style="font-size:.74rem;">
                                {{ $log->started_at->diffForHumans() }}
                            </span>
                        </div>
                        <div style="font-size:.78rem;">
                            <span class="text-success me-2">
                                <i class="bi bi-check-circle me-1"></i>{{ $log->synced_count }} synced
                            </span>
                            @if($log->conflict_count > 0)
                            <span class="text-warning me-2">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $log->conflict_count }} conflicts
                            </span>
                            @endif
                            @if($log->error_count > 0)
                            <span class="text-danger">
                                <i class="bi bi-x-circle me-1"></i>{{ $log->error_count }} errors
                            </span>
                            @endif
                        </div>
                        @if($log->triggered_by)
                        <div class="text-muted" style="font-size:.74rem;">
                            by {{ $log->triggeredBy?->full_name ?? 'System' }}
                            @if($log->duration) · {{ $log->duration }} @endif
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                        No sync runs yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
</div>
