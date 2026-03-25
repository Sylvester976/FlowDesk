<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">Roles &amp; Hierarchy</h1>
                <nav class="breadcrumb">
                    <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="breadcrumb-item">Administration</a>
                    <span class="breadcrumb-item active">Roles &amp; Hierarchy</span>
                </nav>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                <div class="page-header-actions">
                    <button wire:click="openRoleForm()" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>
                        <span class="d-none d-sm-inline">Add Role</span>
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="row g-3 mb-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="col-12 col-lg-6" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'role-'.e($role->id).''; ?>wire:key="role-<?php echo e($role->id); ?>">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            
                            <span class="badge rounded-pill"
                                  style="background:#1a3a6b;color:#fff;font-size:.72rem;min-width:26px;">
                        L<?php echo e($role->hierarchy_level); ?>

                    </span>
                            <h5 class="card-title mb-0 flex-grow-1"><?php echo e($role->label); ?></h5>
                            <div class="d-flex align-items-center gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role->can_supervise): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"
                                          style="font-size:.7rem;">supervises</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role->is_ps): ?>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle"
                                          style="font-size:.7rem;">PS</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin() && ! $role->is_system): ?>
                                    <button wire:click="openRoleForm(<?php echo e($role->id); ?>)"
                                            class="btn btn-sm btn-outline-secondary p-1"
                                            style="width:26px;height:26px;display:flex;align-items:center;justify-content:center;"
                                            title="Edit role">
                                        <i class="bi bi-pencil" style="font-size:.72rem;"></i>
                                    </button>
                                    <button wire:click="confirmDeleteRole(<?php echo e($role->id); ?>)"
                                            class="btn btn-sm btn-outline-danger p-1"
                                            style="width:26px;height:26px;display:flex;align-items:center;justify-content:center;"
                                            title="Delete role">
                                        <i class="bi bi-trash" style="font-size:.72rem;"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body pt-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted" style="font-size:.78rem;">
                            <i class="bi bi-people me-1"></i>
                            <?php echo e($role->users_count ?? $role->users->count()); ?> staff assigned
                        </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                                    <button wire:click="openTitleForm(<?php echo e($role->id); ?>)"
                                            class="btn btn-sm btn-outline-primary py-0 px-2"
                                            style="font-size:.75rem;">
                                        <i class="bi bi-plus me-1"></i>Add title
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role->jobTitles->count()): ?>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $role->jobTitles->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <span class="badge d-inline-flex align-items-center gap-1"
                                              style="background:#f0f4ff;color:#1a3a6b;border:1px solid #c8d8f8;font-size:.74rem;font-weight:400;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($title->is_default): ?>
                                                <i class="bi bi-star-fill" style="font-size:.6rem;color:#c8a951;"></i>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php echo e($title->name); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                                                <span style="cursor:pointer;margin-left:2px;"
                                                      wire:click="openTitleForm(<?php echo e($role->id); ?>, <?php echo e($title->id); ?>)"
                                                      title="Edit">
                                <i class="bi bi-pencil" style="font-size:.6rem;"></i>
                            </span>
                                                <span style="cursor:pointer;color:#dc3545;"
                                                      wire:click="confirmDeleteTitle(<?php echo e($title->id); ?>)"
                                                      title="Delete">
                                <i class="bi bi-x" style="font-size:.75rem;"></i>
                            </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0" style="font-size:.78rem;">No job titles yet.</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2 text-primary"></i>System Permissions
                    </h5>
                    <div class="card-actions">
                        <div class="input-group input-group-sm" style="width:220px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="permSearch"
                                   class="form-control" placeholder="Search staff...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Staff</th>
                                <th class="d-none d-md-table-cell">Role</th>
                                <th class="d-none d-md-table-cell">Division</th>
                                <th>Superadmin</th>
                                <th>HR Admin</th>
                                <th style="width:80px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $permUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'perm-'.e($u->id).''; ?>wire:key="perm-<?php echo e($u->id); ?>">
                                    <td>
                                        <div class="fw-medium" style="font-size:.85rem;"><?php echo e($u->full_name); ?></div>
                                        <div class="text-muted" style="font-size:.75rem;"><?php echo e($u->email); ?></div>
                                        
                                        <div class="d-md-none mt-1">
                                    <span class="badge bg-light text-dark border" style="font-size:.7rem;">
                                        <?php echo e($u->role?->label); ?>

                                    </span>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                        <?php echo e($u->role?->label ?? '—'); ?>

                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                        <?php echo e($u->department?->name ?? '—'); ?>

                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($u->is_superadmin): ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle"
                                                  style="font-size:.75rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Yes
                                    </span>
                                        <?php else: ?>
                                            <span class="text-muted" style="font-size:.78rem;">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($u->is_hr_admin): ?>
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle"
                                                style="font-size:.75rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Yes
                                    </span>
                                        <?php else: ?>
                                            <span class="text-muted" style="font-size:.78rem;">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <button wire:click="openPermissions(<?php echo e($u->id); ?>)"
                                                class="btn btn-sm btn-outline-primary py-0 px-2"
                                                style="font-size:.75rem;">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No staff found.
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showRoleForm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e($editingRoleId ? 'Edit Role' : 'Add Role'); ?></h5>
                        <button wire:click="resetRoleForm" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Role name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="role_name"
                                       class="form-control <?php $__errorArgs = ['role_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="e.g. principal_officer">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['role_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="form-text">Lowercase, underscores only.</div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Display label <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="role_label"
                                       class="form-control <?php $__errorArgs = ['role_label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="e.g. Principal Officer">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['role_label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-medium">Hierarchy level <span
                                        class="text-danger">*</span></label>
                                <input type="number" wire:model="role_level" min="1" max="20"
                                       class="form-control <?php $__errorArgs = ['role_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <div class="form-text">Lower = higher in org. PS = 1.</div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['role_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 d-flex align-items-end pb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           wire:model="role_can_supervise" id="canSupervise">
                                    <label class="form-check-label" for="canSupervise">
                                        Can supervise others
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('showRoleForm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="saveRole" class="btn btn-primary btn-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save Role</span>
                            <span wire:loading><span
                                    class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showTitleForm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?php echo e($editingTitleId ? 'Edit' : 'Add'); ?> Job Title
                            <small class="text-muted fw-normal">— <?php echo e($activeTitleRoleName); ?></small>
                        </h5>
                        <button wire:click="$set('showTitleForm', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Job title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="title_name"
                                   class="form-control <?php $__errorArgs = ['title_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="e.g. ICT Officer I">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   wire:model="title_is_default" id="titleDefault">
                            <label class="form-check-label" for="titleDefault">
                                Set as default for this role
                                <small class="text-muted d-block">Default title is pre-selected when HR creates staff at
                                    this role level.</small>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('showTitleForm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="saveTitle" class="btn btn-primary btn-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading><span
                                    class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPermissionsModal): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Permissions — <?php echo e($permUserName); ?>

                        </h5>
                        <button wire:click="$set('showPermissionsModal', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3 rounded mb-3" style="background:#fff8e1;border-left:4px solid #c8a951;">
                            <p class="mb-0" style="font-size:.82rem;color:#78620a;">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                These permissions override the user's role. Grant with care.
                            </p>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox"
                                   wire:model="perm_is_superadmin" id="permSA" role="switch">
                            <label class="form-check-label fw-medium" for="permSA">
                                Superadmin
                                <small class="text-muted d-block fw-normal">Full system access — all staff, all
                                    applications, all settings.</small>
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   wire:model="perm_is_hr_admin" id="permHR" role="switch">
                            <label class="form-check-label fw-medium" for="permHR">
                                HR Admin
                                <small class="text-muted d-block fw-normal">Can create and manage staff accounts
                                    regardless of role.</small>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('showPermissionsModal', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="savePermissions" class="btn btn-primary btn-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save Permissions</span>
                            <span wire:loading><span
                                    class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteConfirm): ?>
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Delete <strong><?php echo e($deleteLabel); ?></strong>? This cannot be undone.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button wire:click="$set('showDeleteConfirm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="executeDelete"
                                class="btn btn-danger btn-sm" wire:loading.attr="disabled">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/admin/roles-manager.blade.php ENDPATH**/ ?>