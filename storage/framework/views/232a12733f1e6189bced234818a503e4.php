<div>
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Staff Member</h1>
                <nav class="breadcrumb">
                    <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="breadcrumb-item">Staff</a>
                    <span class="breadcrumb-item active">Edit — <?php echo e($staff->full_name); ?></span>
                </nav>
            </div>
            <div class="page-header-actions">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isSuperAdmin()): ?>
                    <button type="button"
                            wire:click="$dispatch('notify', {type: 'info', message: 'Use staff list to force password change.'})"
                            class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-key me-1"></i>
                        <span class="d-none d-sm-inline">Force Password Reset</span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="card mb-3 border-0" style="background:#e8f0fb;">
            <div class="card-body py-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="user-initials-avatar" style="width:42px;height:42px;font-size:.85rem;">
                        <?php echo e(strtoupper(substr($staff->first_name,0,1).substr($staff->last_name,0,1))); ?>

                    </div>
                    <div>
                        <div class="fw-semibold" style="color:#1a3a6b;"><?php echo e($staff->full_name); ?></div>
                        <div class="text-muted" style="font-size:.78rem;">
                            <?php echo e($staff->email); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($staff->pf_number): ?>
                                · PF: <?php echo e($staff->pf_number); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            · Joined <?php echo e($staff->created_at->format('M Y')); ?>

                        </div>
                    </div>
                    <div class="ms-auto">
                    <span
                        class="badge <?php echo e($staff->status === 'active' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'); ?>">
                        <?php echo e(ucfirst($staff->status)); ?>

                    </span>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit="save" novalidate>
            <?php echo $__env->make('livewire.admin._staff-form', ['isEdit' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/admin/edit-staff.blade.php ENDPATH**/ ?>