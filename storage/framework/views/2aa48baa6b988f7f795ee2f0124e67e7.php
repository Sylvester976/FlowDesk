<div>
    <div class="auth-card-header text-center">
        <div class="mb-3">
            <span style="display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:50%;background:#e8f5ee;">
                <i class="bi bi-key fs-4" style="color:#006b3f"></i>
            </span>
        </div>
        <h1 class="auth-title">Set your password</h1>
        <p class="auth-subtitle">You must set a new password before continuing.</p>
    </div>

    <form wire:submit="save" class="auth-form" novalidate>

        
        <div class="form-group">
            <label class="form-label fw-medium">New Password <span class="text-danger">*</span></label>
            <div class="input-group" x-data="{ show: false }">
                <input
                    :type="show ? 'text' : 'password'"
                    wire:model.live="password"
                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Minimum 8 characters"
                    autocomplete="new-password"
                    autofocus
                >
                <button class="btn btn-outline-secondary" type="button"
                    @click="show = !show" tabindex="-1">
                    <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                </button>
            </div>
        </div>

        
        <div class="form-group">
            <label class="form-label fw-medium">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group" x-data="{ show: false }">
                <input
                    :type="show ? 'text' : 'password'"
                    wire:model.live="password_confirmation"
                    class="form-control"
                    placeholder="Repeat your password"
                    autocomplete="new-password"
                >
                <button class="btn btn-outline-secondary" type="button"
                    @click="show = !show" tabindex="-1">
                    <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                </button>
            </div>
        </div>

        
        <div class="mb-3 p-3 rounded" style="background:#f8f9fa; font-size:.82rem;">
            <div class="fw-medium mb-2" style="color:#374151;">Password requirements:</div>
            <div class="d-flex flex-column gap-1">
                <div style="color: <?php echo e($req_length ? '#006b3f' : '#9ca3af'); ?>;">
                    <i class="bi <?php echo e($req_length ? 'bi-check-circle-fill' : 'bi-circle'); ?> me-2"></i>
                    At least 8 characters
                </div>
                <div style="color: <?php echo e($req_uppercase ? '#006b3f' : '#9ca3af'); ?>;">
                    <i class="bi <?php echo e($req_uppercase ? 'bi-check-circle-fill' : 'bi-circle'); ?> me-2"></i>
                    One uppercase letter (A–Z)
                </div>
                <div style="color: <?php echo e($req_number ? '#006b3f' : '#9ca3af'); ?>;">
                    <i class="bi <?php echo e($req_number ? 'bi-check-circle-fill' : 'bi-circle'); ?> me-2"></i>
                    One number (0–9)
                </div>
                <div style="color: <?php echo e($req_special ? '#006b3f' : '#9ca3af'); ?>;">
                    <i class="bi <?php echo e($req_special ? 'bi-check-circle-fill' : 'bi-circle'); ?> me-2"></i>
                    One special character (@$!%*#?&)
                </div>
                <div style="color: <?php echo e($req_match ? '#006b3f' : '#9ca3af'); ?>;">
                    <i class="bi <?php echo e($req_match ? 'bi-check-circle-fill' : 'bi-circle'); ?> me-2"></i>
                    Passwords match
                </div>
            </div>
        </div>

        <button
            type="submit"
            class="btn btn-primary btn-block"
            wire:loading.attr="disabled"
            <?php if(!($req_length && $req_uppercase && $req_number && $req_special && $req_match)): ?>
                style="opacity:.6;"
            <?php endif; ?>
        >
            <span wire:loading.remove>
                <i class="bi bi-check-lg me-1"></i> Set Password &amp; Continue
            </span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2"></span>Saving...
            </span>
        </button>

    </form>
</div>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/livewire/auth/change-password.blade.php ENDPATH**/ ?>