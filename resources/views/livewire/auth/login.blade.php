<div>
    <div class="auth-card-header">
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-subtitle">Enter your official credentials to access your account</p>
    </div>

    <form wire:submit="submit" class="auth-form" novalidate>

        <div class="form-group">
            <label for="email" class="form-label">Official Email</label>
            <input
                type="email"
                wire:model="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="name@organization.go.ke"
                autocomplete="email"
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Password</label>
                <a href="{{ route('password.request') }}" class="auth-link small">Forgot password?</a>
            </div>
        <div class="input-group" x-data="{ show: false }">
            <input
                :type="show ? 'text' : 'password'"
                wire:model="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter your password"
                autocomplete="current-password"
            >
            <button class="btn btn-outline-secondary" type="button" @click="show = !show" tabindex="-1">
                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
            </button>
        </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" wire:model="remember" id="remember">
            <label class="form-check-label small" for="remember">Keep me signed in</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
            <span wire:loading.remove>Sign In</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Sending code...
            </span>
        </button>

        <p class="text-center text-muted mt-3 mb-0" style="font-size:.82rem;">
            <i class="bi bi-shield-lock me-1"></i>
            A one-time verification code will be sent to your email.
        </p>

    </form>
</div>
