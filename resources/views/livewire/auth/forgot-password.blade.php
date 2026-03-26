<div>
    <div class="auth-card-header">

        {{-- Logo --}}
        <div class="auth-logo mb-3">
            <img src="{{ asset('assets/img/logo.png') }}" alt="FlowDesk">
        </div>

        {{-- Progress indicator --}}
        <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
            @foreach([1 => 'Email', 2 => 'Verify', 3 => 'Reset'] as $s => $label)
            <div class="d-flex align-items-center gap-1">
                <div style="width:28px;height:28px;border-radius:50%;font-size:.72rem;font-weight:600;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;
                    background:{{ $step >= $s ? '#1a3a6b' : '#e9ecef' }};
                    color:{{ $step >= $s ? '#fff' : '#adb5bd' }};">
                    @if($step > $s)
                        <i class="bi bi-check-lg" style="font-size:.7rem;"></i>
                    @else
                        {{ $s }}
                    @endif
                </div>
                <span style="font-size:.75rem;white-space:nowrap;
                    color:{{ $step === $s ? '#1a3a6b' : '#adb5bd' }};
                    font-weight:{{ $step === $s ? '600' : '400' }};">
                    {{ $label }}
                </span>
                @if($s < 3)
                <div style="width:24px;height:1px;background:{{ $step > $s ? '#1a3a6b' : '#dee2e6' }};"></div>
                @endif
            </div>
            @endforeach
        </div>

    </div>

    <div class="auth-form">

        {{-- ── Step 1: Email ───────────────────────────────── --}}
        @if($step === 1)
        <div class="mb-3">
            <h1 class="auth-title">Forgot Password?</h1>
            <p class="auth-subtitle">Enter your work email and we'll send you a reset code.</p>
        </div>

        <div class="mb-4">
            <label class="form-label fw-medium">Work Email</label>
            <input type="email" wire:model="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                placeholder="you@ict.go.ke"
                wire:keydown.enter="sendOtp"
                autocomplete="email">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button wire:click="sendOtp" class="btn w-100 mb-3"
            style="background:#1a3a6b;color:#fff;border:none;padding:.75rem;font-size:1rem;border-radius:8px;"
            wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="bi bi-send me-1"></i> Send Reset Code
            </span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2"></span>Sending...
            </span>
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" style="font-size:.84rem;color:#1a3a6b;">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>
        </div>
        @endif

        {{-- ── Step 2: OTP ─────────────────────────────────── --}}
        @if($step === 2)
        <div class="mb-3">
            <h1 class="auth-title">Enter Reset Code</h1>
            <p class="auth-subtitle">
                A 6-digit code was sent to <strong>{{ $email }}</strong>.
                Expires in 15 minutes.
            </p>
        </div>

        <div class="mb-4">
            <label class="form-label fw-medium">Reset Code</label>
            <input type="text" wire:model="otp"
                class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                placeholder="000000"
                maxlength="6"
                wire:keydown.enter="verifyOtp"
                autocomplete="one-time-code"
                style="font-size:1.6rem;font-family:monospace;letter-spacing:.3em;">
            @error('otp')<div class="invalid-feedback text-center">{{ $message }}</div>@enderror
        </div>

        <button wire:click="verifyOtp" class="btn w-100 mb-3"
            style="background:#1a3a6b;color:#fff;border:none;padding:.75rem;font-size:1rem;border-radius:8px;"
            wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="bi bi-shield-check me-1"></i> Verify Code
            </span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2"></span>Verifying...
            </span>
        </button>

        <div class="d-flex justify-content-between" style="font-size:.83rem;">
            <button wire:click="$set('step', 1)"
                class="btn btn-link p-0 text-decoration-none" style="font-size:.83rem;color:#6c757d;">
                <i class="bi bi-arrow-left me-1"></i> Change email
            </button>
            <button wire:click="resendOtp"
                class="btn btn-link p-0 text-decoration-none" style="font-size:.83rem;color:#1a3a6b;">
                Resend code
            </button>
        </div>
        @endif

        {{-- ── Step 3: New password ────────────────────────── --}}
        @if($step === 3)
        <div class="mb-3">
            <h1 class="auth-title">Set New Password</h1>
            <p class="auth-subtitle">Choose a strong password for your account.</p>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">New Password</label>
            <input type="password" wire:model.live="new_password"
                class="form-control form-control-lg @error('new_password') is-invalid @enderror"
                autocomplete="new-password">
            @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Confirm Password</label>
            <input type="password" wire:model.live="confirm_password"
                class="form-control form-control-lg @error('confirm_password') is-invalid @enderror"
                wire:keydown.enter="resetPassword"
                autocomplete="new-password">
            @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Requirements checklist --}}
        <div class="mb-4 p-3 rounded" style="background:#f8f9fa;font-size:.82rem;">
            @php
                $checks = [
                    ['pass' => strlen($new_password) >= 8,                      'label' => 'At least 8 characters'],
                    ['pass' => (bool) preg_match('/[A-Z]/', $new_password),      'label' => 'One uppercase letter'],
                    ['pass' => (bool) preg_match('/[0-9]/', $new_password),      'label' => 'One number'],
                    ['pass' => (bool) preg_match('/[@$!%*#?&]/', $new_password), 'label' => 'One special character (@$!%*#?&)'],
                ];
            @endphp
            @foreach($checks as $check)
            <div class="d-flex align-items-center gap-2 {{ !$loop->last ? 'mb-2' : '' }}">
                <i class="bi bi-{{ $check['pass'] ? 'check-circle-fill text-success' : 'circle text-muted' }}"
                    style="font-size:.82rem;flex-shrink:0;"></i>
                <span style="color:{{ $check['pass'] ? '#006b3f' : '#6c757d' }};">
                    {{ $check['label'] }}
                </span>
            </div>
            @endforeach
        </div>

        <button wire:click="resetPassword" class="btn w-100"
            style="background:#1a3a6b;color:#fff;border:none;padding:.75rem;font-size:1rem;border-radius:8px;"
            wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="bi bi-shield-lock me-1"></i> Reset Password
            </span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2"></span>Resetting...
            </span>
        </button>
        @endif

    </div>
</div>
