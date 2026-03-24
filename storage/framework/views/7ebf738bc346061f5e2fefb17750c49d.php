<div>
<div class="main-content page-staff">

    
    <div class="page-header">
        <div>
            <h1 class="page-title">Staff Management</h1>
            <nav class="breadcrumb">
                <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Staff</span>
            </nav>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canManageUsers()): ?>
        <div class="page-header-actions">
            <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>
                <span class="d-none d-sm-inline">Add Staff</span>
            </a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="card mb-3">
        <div class="card-body py-3">
            <div class="row g-2">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control" placeholder="Search name, email, PF number...">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="filterRole" class="form-select form-select-sm">
                        <option value="">All roles</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->label); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="filterStatus" class="form-select form-select-sm">
                        <option value="">All status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="filterDir" class="form-select form-select-sm">
                        <option value="">All directorates</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $directorates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($dir->id); ?>"><?php echo e($dir->name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="filterDept" class="form-select form-select-sm"
                        <?php if(!$filterDir): ?> disabled <?php endif; ?>>
                        <option value="">All departments</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
    <div class="card mb-3" x-data x-show="$wire.selected.length > 0"
        style="display:none!important;" x-cloak
        x-bind:style="$wire.selected.length > 0 ? 'display:block!important' : 'display:none!important'">
        <div class="card-body py-2 d-flex align-items-center gap-3 flex-wrap">
            <span class="text-muted small fw-medium">
                <span x-text="$wire.selected.length"></span> selected
            </span>
            <select wire:model="bulkAction" class="form-select form-select-sm" style="width:auto;">
                <option value="">Choose action...</option>
                <option value="activate">Activate</option>
                <option value="deactivate">Deactivate</option>
                <option value="force_password">Force password change</option>
            </select>
            <button wire:click="confirmBulk" class="btn btn-sm btn-primary"
                <?php if(!$bulkAction): ?> disabled <?php endif; ?>>
                Apply
            </button>
            <button wire:click="$set('selected', [])" class="btn btn-sm btn-outline-secondary">
                Clear selection
            </button>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                            <th style="width:40px;">
                                <input type="checkbox" wire:model.live="selectAll" class="form-check-input">
                            </th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <th>Staff</th>
                            <th class="d-none d-md-table-cell">Role</th>
                            <th class="d-none d-lg-table-cell">Department</th>
                            <th class="d-none d-xl-table-cell">Supervisor</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Days used</th>
                            <th style="width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'staff-'.e($member->id).''; ?>wire:key="staff-<?php echo e($member->id); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                            <td>
                                <input type="checkbox" wire:model.live="selected"
                                    value="<?php echo e($member->id); ?>" class="form-check-input"
                                    <?php if($member->role?->is_system): ?> disabled <?php endif; ?>>
                            </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-initials-avatar" style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($member->first_name,0,1).substr($member->last_name,0,1))); ?>

                                    </div>
                                    <div>
                                        <div class="fw-medium" style="font-size:.88rem;">
                                            <?php echo e($member->full_name); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->force_password_change): ?>
                                                <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem;">
                                                    <i class="bi bi-key"></i> pwd
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="text-muted" style="font-size:.78rem;"><?php echo e($member->email); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->pf_number): ?>
                                            <div class="text-muted" style="font-size:.74rem;">PF: <?php echo e($member->pf_number); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <div class="d-md-none mt-1">
                                            <span class="badge bg-light text-dark border" style="font-size:.7rem;"><?php echo e($member->role?->label); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->department): ?>
                                                <span class="text-muted" style="font-size:.74rem;"> · <?php echo e($member->department->name); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge bg-light text-dark border" style="font-size:.75rem;">
                                    <?php echo e($member->role?->label ?? '—'); ?>

                                </span>
                            </td>
                            <td class="d-none d-lg-table-cell" style="font-size:.83rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->department): ?>
                                    <div><?php echo e($member->department->name); ?></div>
                                    <div class="text-muted" style="font-size:.75rem;"><?php echo e($member->department->directorate?->name); ?></div>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="d-none d-xl-table-cell" style="font-size:.83rem;">
                                <?php echo e($member->supervisor?->full_name ?? '—'); ?>

                            </td>
                            <td>
                                <?php
                                    $badge = match($member->status) {
                                        'active'   => 'success',
                                        'inactive' => 'danger',
                                        default    => 'warning'
                                    };
                                ?>
                                <span class="badge bg-<?php echo e($badge); ?>-subtle text-<?php echo e($badge); ?> border border-<?php echo e($badge); ?>-subtle"
                                    style="font-size:.75rem;">
                                    <?php echo e(ucfirst($member->status)); ?>

                                </span>
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                <?php echo e($member->days_used_this_year); ?> / <?php echo e($member->max_days_per_year); ?>

                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.staff.edit', $member->id)); ?>"
                                        class="btn btn-sm btn-outline-primary p-1" title="Edit"
                                        style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-pencil" style="font-size:.75rem;"></i>
                                    </a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin() && ! $member->role?->is_system): ?>
                                    <button wire:click="toggleStatus(<?php echo e($member->id); ?>)"
                                        class="btn btn-sm p-1 <?php echo e($member->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success'); ?>"
                                        title="<?php echo e($member->status === 'active' ? 'Deactivate' : 'Activate'); ?>"
                                        style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi <?php echo e($member->status === 'active' ? 'bi-person-x' : 'bi-person-check'); ?>"
                                            style="font-size:.75rem;"></i>
                                    </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                No staff found matching your filters.
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($staff->hasPages()): ?>
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Showing <?php echo e($staff->firstItem()); ?>–<?php echo e($staff->lastItem()); ?> of <?php echo e($staff->total()); ?> staff
            </div>
            <?php echo e($staff->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showConfirm): ?>
    <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Action</h5>
                    <button wire:click="$set('showConfirm', false)" class="btn-close"></button>
                </div>
                <div class="modal-body"><?php echo e($confirmText); ?></div>
                <div class="modal-footer">
                    <button wire:click="$set('showConfirm', false)" class="btn btn-outline-secondary btn-sm">Cancel</button>
                    <button wire:click="executeBulk" class="btn btn-primary btn-sm">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/admin/staff-list.blade.php ENDPATH**/ ?>