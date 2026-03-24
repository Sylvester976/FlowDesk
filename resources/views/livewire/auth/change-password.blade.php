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

        {{-- Password field --}}
        <div class="form-group">
            <label class="form-label fw-medium">New Password <span class="text-danger">*</span></label>
            <div class="input-group" x-data="{ show: false }">
                <input
                    :type="show ? 'text' : 'password'"
                    wire:model.live="password"
                    class="form-control @error('password') is-invalid @enderror"
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

        {{-- Confirm password --}}
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

        {{-- Live requirements checklist --}}
        <div class="mb-3 p-3 rounded" style="background:#f8f9fa; font-size:.82rem;">
            <div class="fw-medium mb-2" style="color:#374151;">Password requirements:</div>
            <div class="d-flex flex-column gap-1">
                <div style="color: {{ $req_length ? '#006b3f' : '#9ca3af' }};">
                    <i class="bi {{ $req_length ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                    At least 8 characters
                </div>
                <div style="color: {{ $req_uppercase ? '#006b3f' : '#9ca3af' }};">
                    <i class="bi {{ $req_uppercase ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                    One uppercase letter (A–Z)
                </div>
                <div style="color: {{ $req_number ? '#006b3f' : '#9ca3af' }};">
                    <i class="bi {{ $req_number ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                    One number (0–9)
                </div>
                <div style="color: {{ $req_special ? '#006b3f' : '#9ca3af' }};">
                    <i class="bi {{ $req_special ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                    One special character (@$!%*#?&)
                </div>
                <div style="color: {{ $req_match ? '#006b3f' : '#9ca3af' }};">
                    <i class="bi {{ $req_match ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                    Passwords match
                </div>
            </div>
        </div>

        <button
            type="submit"
            class="btn btn-primary btn-block"
            wire:loading.attr="disabled"
            @if(!($req_length && $req_uppercase && $req_number && $req_special && $req_match))
                style="opacity:.6;"
            @endif
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
