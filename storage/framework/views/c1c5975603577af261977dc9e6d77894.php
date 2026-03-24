<div class="header-action dropdown notification-dropdown">
    <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
        <i class="bi bi-bell"></i>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
            <span class="badge"><?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </button>

    <div class="dropdown-menu dropdown-menu-end" style="width:360px;max-width:95vw;">
        <div class="notification-header d-flex align-items-center justify-content-between">
            <h6 class="mb-0">Notifications</h6>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
            <button wire:click="markAllRead"
                class="btn btn-link btn-sm p-0 text-decoration-none"
                style="font-size:.78rem;color:#1a3a6b;">
                Mark all read
            </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="notification-list" style="max-height:380px;overflow-y:auto;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
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
            ?>
            <a href="<?php echo e($data['url'] ?? '#'); ?>"
                wire:click="markRead('<?php echo e($notification->id); ?>')"
                class="notification-item d-flex align-items-start gap-2 text-decoration-none p-3
                    <?php echo e($isRead ? '' : 'unread'); ?>"
                style="border-bottom:1px solid var(--bs-border-color);">

                <div style="width:34px;height:34px;border-radius:8px;flex-shrink:0;
                    background:<?php echo e($colors['bg']); ?>;display:flex;align-items:center;justify-content:center;">
                    <i class="bi <?php echo e($icon); ?>" style="color:<?php echo e($colors['icon']); ?>;font-size:.9rem;"></i>
                </div>

                <div class="flex-grow-1 min-width-0">
                    <div style="font-size:.82rem;line-height:1.5;
                        color:var(--bs-body-color);
                        font-weight:<?php echo e($isRead ? '400' : '500'); ?>;">
                        <?php echo e($data['message'] ?? 'New notification'); ?>

                    </div>
                    <div class="text-muted mt-1" style="font-size:.73rem;">
                        <?php echo e($notification->created_at->diffForHumans()); ?>

                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $isRead): ?>
                <div style="width:7px;height:7px;border-radius:50%;
                    background:#1a3a6b;flex-shrink:0;margin-top:6px;"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="p-4 text-center text-muted" style="font-size:.84rem;">
                <i class="bi bi-check-circle d-block mb-2 fs-4 text-success"></i>
                All caught up — no notifications.
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notifications->count()): ?>
        <div class="notification-footer text-center py-2">
            <a href="<?php echo e(route('notifications.index')); ?>"
                style="font-size:.8rem;color:#1a3a6b;text-decoration:none;">
                View all notifications
            </a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/notification-bell.blade.php ENDPATH**/ ?>