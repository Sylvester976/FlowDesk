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
    public string $email    = '';
    public string $password = '';
    public bool $remember   = false;

    protected array $rules = [
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ];

    public function submit(): void
    {
        $this->validate();

        $key = 'login:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            AuthLog::record('lockout', null, $this->email, "Too many attempts. Locked for {$seconds}s");
            $this->dispatch('notify', type: 'error', message: "Too many attempts. Please wait {$seconds} seconds.");
            $this->addError('email', "Too many login attempts. Please wait {$seconds} seconds.");
            return;
        }

        $user = User::where('email', $this->email)->first();

        if (! $user || ! password_verify($this->password, $user->password)) {
            RateLimiter::hit($key, 60);
            AuthLog::record('login_failed', $user?->id, $this->email);
            $this->dispatch('notify', type: 'error', message: 'Invalid email or password.');
            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        if ($user->status !== 'active') {
            AuthLog::record('login_failed', $user->id, $this->email, 'Account not active: ' . $user->status);
            $this->dispatch('notify', type: 'warning', message: 'Your account is not active. Contact the administrator.');
            $this->addError('email', 'Your account is not active. Please contact the administrator.');
            return;
        }

        RateLimiter::clear($key);

        Otp::where('user_id', $user->id)->where('used', false)->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(5),
            'used'       => false,
            'attempts'   => 0,
            'ip_address' => request()->ip(),
        ]);

        Mail::to($user->email)->send(new OtpMail($user, $code));

        AuthLog::record('otp_sent', $user->id, $user->email);

        // Flash — shows as notie on the OTP page after redirect
        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Code sent! Check your email.');

        session([
            'otp_user_id'  => $user->id,
            'otp_remember' => $this->remember,
        ]);

        // navigate: false so session flash survives the redirect
        $this->redirect(route('auth.otp'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.auth');
    }
}
