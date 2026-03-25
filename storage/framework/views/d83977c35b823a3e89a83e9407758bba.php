<div>
    <div class="main-content">
        <div class="page-header">
            <div>
                <h1 class="page-title">Add Staff Member</h1>
                <nav class="breadcrumb">
                    <a href="<?php echo e(route('dashboard')); ?>" class="breadcrumb-item">Home</a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="breadcrumb-item">Staff</a>
                    <span class="breadcrumb-item active">Add</span>
                </nav>
            </div>
        </div>

        <form wire:submit="save" novalidate>
            <?php echo $__env->make('livewire.admin._staff-form', ['isEdit' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/admin/create-staff.blade.php ENDPATH**/ ?>