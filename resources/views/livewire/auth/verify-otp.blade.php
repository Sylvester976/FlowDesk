<div>
    <div class="auth-card-header text-center">
        <div class="mb-3">
            <span style="display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:50%;background:#e8f0fb;">
                <i class="bi bi-envelope-check fs-4" style="color:#1a3a6b"></i>
            </span>
        </div>
        <h1 class="auth-title">Check your email</h1>
        <p class="auth-subtitle">We sent a 6-digit code to your registered email address.</p>
    </div>

    <div class="auth-form">

        @if(session('resent'))
            <div class="alert alert-success py-2 small text-center mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('resent') }}
            </div>
        @endif

        <form wire:submit="submit" novalidate>
            <div class="form-group">
                <label class="form-label text-center d-block">One-time code</label>
                <input
                    type="text"
                    wire:model="code"
                    class="form-control text-center fw-bold @error('code') is-invalid @enderror"
                    placeholder="000000"
                    maxlength="6"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                    style="font-size:1.8rem; letter-spacing:.6em; padding:14px 10px;"
                >
                @error('code')
                    <div class="invalid-feedback text-center">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                <span wire:loading.remove>Verify &amp; Sign In</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Verifying...
                </span>
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted mb-2" style="font-size:.83rem;">Didn't receive the code?</p>
            <button wire:click="resend" wire:loading.attr="disabled" class="btn btn-link btn-sm p-0 auth-link text-decoration-none">
                <span wire:loading.remove wire:target="resend">Resend code</span>
                <span wire:loading wire:target="resend">Sending...</span>
            </button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to sign in
            </a>
        </div>

    </div>
</div>
