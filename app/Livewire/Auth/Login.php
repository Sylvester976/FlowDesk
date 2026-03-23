<?php

namespace App\Livewire\Auth;

use App\Mail\OtpMail;
use App\Models\AuthLog;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ];

    public function submit(): void
    {
        $this->validate();

        // Rate limit: 5 attempts per minute per IP
        $key = 'login:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            AuthLog::record('lockout', null, $this->email, "Too many attempts. Locked for {$seconds}s");

            $this->addError('email', "Too many login attempts. Please wait {$seconds} seconds.");
            return;
        }

        // Find user by email
        $user = User::where('email', $this->email)->first();

        if (!$user || !password_verify($this->password, $user->password)) {
            RateLimiter::hit($key, 60);

            AuthLog::record('login_failed', $user?->id, $this->email);

            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        // Account status check
        if ($user->status !== 'active') {
            AuthLog::record('login_failed', $user->id, $this->email, 'Account not active: ' . $user->status);
            $this->addError('email', 'Your account is not active. Please contact the administrator.');
            return;
        }

        RateLimiter::clear($key);

        // Invalidate any previous unused OTPs
        Otp::where('user_id', $user->id)->where('used', false)->delete();

        // Generate new OTP
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $otp = Otp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
            'used' => false,
            'attempts' => 0,
            'ip_address' => request()->ip(),
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($user, $code));

        AuthLog::record('otp_sent', $user->id, $user->email);

        // Store user ID in session for OTP step — not authenticated yet
        session([
            'otp_user_id' => $user->id,
            'otp_remember' => $this->remember,
        ]);

        $this->redirect(route('auth.otp'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.auth');
    }
}
