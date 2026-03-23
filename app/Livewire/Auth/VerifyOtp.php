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
    public int $resendCooldown = 60;

    protected array $rules = [
        'code' => ['required', 'digits:6'],
    ];

    public function mount(): void
    {
        if (! session('otp_user_id')) {
            $this->redirect(route('login'), navigate: false);
        }
    }

    public function submit(): void
    {
        $this->validate();

        $userId = session('otp_user_id');
        $user   = User::find($userId);

        if (! $user) {
            $this->redirect(route('login'), navigate: false);
            return;
        }

        $otp = Otp::where('user_id', $userId)
            ->where('used', false)
            ->latest()
            ->first();

        if (! $otp) {
            $this->dispatch('notify', type: 'error', message: 'No active code found. Please sign in again.');
            $this->addError('code', 'No active code found. Please go back and sign in again.');
            return;
        }

        $otp->increment('attempts');

        if ($otp->attempts > 3) {
            $otp->update(['used' => true]);
            AuthLog::record('otp_failed', $user->id, $user->email, 'Max attempts exceeded');
            session()->forget(['otp_user_id', 'otp_remember']);
            $this->dispatch('notify', type: 'error', message: 'Too many incorrect attempts. Please sign in again.');
            $this->addError('code', 'Too many incorrect attempts. Please sign in again.');
            return;
        }

        if ($otp->isExpired()) {
            AuthLog::record('otp_expired', $user->id, $user->email);
            $this->dispatch('notify', type: 'warning', message: 'Code has expired. Request a new one.');
            $this->addError('code', 'This code has expired. Please request a new one.');
            return;
        }

        if ($otp->code !== $this->code) {
            $remaining = 3 - $otp->attempts;
            AuthLog::record('otp_failed', $user->id, $user->email, "Wrong code. {$remaining} attempts left");
            $this->dispatch('notify', type: 'error', message: "Incorrect code. {$remaining} " . ($remaining === 1 ? 'attempt' : 'attempts') . ' remaining.');
            $this->addError('code', "Incorrect code. {$remaining} " . ($remaining === 1 ? 'attempt' : 'attempts') . ' remaining.');
            return;
        }

        // Success
        $otp->update(['used' => true]);

        $remember = session('otp_remember', false);
        Auth::login($user, $remember);

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        AuthLog::record('login_success', $user->id, $user->email);

        session()->forget(['otp_user_id', 'otp_remember']);

        // Flash welcome — shows on dashboard after redirect
        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Welcome back, ' . $user->first_name . '!');

        $this->redirect($this->dashboardRoute($user), navigate: false);
    }

    public function resend(): void
    {
        $userId = session('otp_user_id');
        $user   = User::find($userId);

        if (! $user) {
            $this->redirect(route('login'), navigate: false);
            return;
        }

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

        $this->dispatch('notify', type: 'info', message: 'New code sent — check your email.');

        $this->canResend      = false;
        $this->resendCooldown = 60;
        $this->code           = '';

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
        return view('livewire.auth.verify-otp')
            ->layout('components.layouts.auth');
    }
}
