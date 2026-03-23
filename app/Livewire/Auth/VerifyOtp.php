<?php

namespace App\Livewire\Auth;

use App\Mail\OtpMail;
use App\Models\AuthLog;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VerifyOtp extends Component
{
    public string $code = '';
    public bool $canResend = false;
    public int $resendCooldown = 60; // seconds

    protected array $rules = [
        'code' => ['required', 'digits:6'],
    ];

    public function mount(): void
    {
        // Guard — must have come from login step
        if (! session('otp_user_id')) {
            $this->redirect(route('login'), navigate: true);
        }
    }

    public function submit(): void
    {
        $this->validate();

        $userId = session('otp_user_id');
        $user   = User::find($userId);

        if (! $user) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        // Find latest valid OTP for this user
        $otp = Otp::where('user_id', $userId)
            ->where('used', false)
            ->latest()
            ->first();

        // No OTP found
        if (! $otp) {
            $this->addError('code', 'No active code found. Please go back and sign in again.');
            return;
        }

        // Increment attempt count
        $otp->increment('attempts');

        // Max attempts exceeded
        if ($otp->attempts > 3) {
            $otp->update(['used' => true]);
            AuthLog::record('otp_failed', $user->id, $user->email, 'Max attempts exceeded');
            session()->forget(['otp_user_id', 'otp_remember']);
            $this->addError('code', 'Too many incorrect attempts. Please sign in again.');
            return;
        }

        // Expired
        if ($otp->isExpired()) {
            AuthLog::record('otp_expired', $user->id, $user->email);
            $this->addError('code', 'This code has expired. Please request a new one.');
            return;
        }

        // Wrong code
        if ($otp->code !== $this->code) {
            $remaining = 3 - $otp->attempts;
            AuthLog::record('otp_failed', $user->id, $user->email, "Wrong code. {$remaining} attempts left");
            $this->addError('code', "Incorrect code. {$remaining} " . ($remaining === 1 ? 'attempt' : 'attempts') . ' remaining.');
            return;
        }

        // Success — mark OTP used
        $otp->update(['used' => true]);

        // Log in the user
        $remember = session('otp_remember', false);
        Auth::login($user, $remember);

        // Update last login info
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        AuthLog::record('login_success', $user->id, $user->email);

        // Clear session
        session()->forget(['otp_user_id', 'otp_remember']);

        // Redirect based on role
        $this->redirect($this->dashboardRoute($user), navigate: true);
    }

    public function resend(): void
    {
        $userId = session('otp_user_id');
        $user   = User::find($userId);

        if (! $user) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        // Invalidate old OTPs
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

        AuthLog::record('otp_sent', $user->id, $user->email, 'Resend requested');

        $this->canResend    = false;
        $this->resendCooldown = 60;
        $this->code         = '';

        session()->flash('resent', 'A new code has been sent to your email.');
    }

    private function dashboardRoute(User $user): string
    {
        if ($user->isSuperAdmin() || $user->isPS()) {
            return route('dashboard.ps');
        }

        if ($user->isHR()) {
            return route('dashboard.hr');
        }

        if ($user->isSupervisor()) {
            return route('dashboard.supervisor');
        }

        return route('dashboard.staff');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.auth');
    }
}
