<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Notifications</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Notifications</span>
            </nav>
        </div>
        @if($unreadCount > 0)
        <div class="page-header-actions">
            <button wire:click="markAllRead" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all me-1"></i>
                Mark all read
                <span class="badge bg-primary ms-1">{{ $unreadCount }}</span>
            </button>
        </div>
        @endif
    </div>

    {{-- Filter tabs --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <ul class="nav nav-pills gap-1">
                <li class="nav-item">
                    <button wire:click="$set('filter', 'all')"
                        class="nav-link {{ $filter === 'all' ? 'active' : '' }} py-1 px-3"
                        style="font-size:.84rem;">
                        All
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="$set('filter', 'unread')"
                        class="nav-link {{ $filter === 'unread' ? 'active' : '' }} py-1 px-3"
                        style="font-size:.84rem;">
                        Unread
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-1" style="font-size:.68rem;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @forelse($notifications as $notification)
            @php
                $data    = $notification->data;
                $isRead  = ! is_null($notification->read_at);
                $color   = $data['color'] ?? 'info';
                $icon    = $data['icon'] ?? 'bi-bell';
                $colorMap = [
                    'success' => ['bg' => '#e8f5ee', 'icon' => '#006b3f'],
                    'warning' => ['bg' => '#fff8e1', 'icon' => '#c8a951'],
                    'danger'  => ['bg' => '#ffebee', 'icon' => '#bb0000'],
                    'info'    => ['bg' => '#e8f0fb', 'icon' => '#1a3a6b'],
                ];
                $colors = $colorMap[$color] ?? $colorMap['info'];
            @endphp
            <div class="d-flex align-items-start gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}
                {{ $isRead ? '' : '' }}"
                style="{{ $isRead ? '' : 'background:var(--bs-tertiary-bg);' }}">

                <div style="width:40px;height:40px;border-radius:10px;flex-shrink:0;
                    background:{{ $colors['bg'] }};display:flex;align-items:center;justify-content:center;">
                    <i class="bi {{ $icon }}" style="color:{{ $colors['icon'] }};font-size:1rem;"></i>
                </div>

                <div class="flex-grow-1">
                    <div style="font-size:.88rem;line-height:1.6;
                        font-weight:{{ $isRead ? '400' : '500' }};
                        color:var(--bs-body-color);">
                        {{ $data['message'] ?? 'New notification' }}
                    </div>
                    @if(isset($data['reference_number']))
                    <div class="mt-1">
                        <span class="badge bg-light text-dark border" style="font-size:.72rem;">
                            {{ $data['reference_number'] }}
                        </span>
                        @if(isset($data['type_label']))
                            <span class="text-muted" style="font-size:.74rem;"> · {{ $data['type_label'] }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="text-muted mt-1" style="font-size:.76rem;">
                        {{ $notification->created_at->format('d M Y, H:i') }}
                        · {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    @if(isset($data['url']))
                    <a href="{{ $data['url'] }}"
                        wire:click="markRead('{{ $notification->id }}')"
                        class="btn btn-sm btn-outline-primary py-0 px-2"
                        style="font-size:.75rem;">
                        View
                    </a>
                    @endif
                    @if(! $isRead)
                    <button wire:click="markRead('{{ $notification->id }}')"
                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                        style="font-size:.75rem;" title="Mark as read">
                        <i class="bi bi-check"></i>
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bell-slash fs-2 d-block mb-2"></i>
                {{ $filter === 'unread' ? 'No unread notifications.' : 'No notifications yet.' }}
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }}
                of {{ $notifications->total() }}
            </div>
            {{ $notifications->links() }}
        </div>
        @endif
    </div>

</div>
</div>
