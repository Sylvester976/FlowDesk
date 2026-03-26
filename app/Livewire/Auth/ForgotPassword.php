<?php

namespace App\Livewire\Auth;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ForgotPassword extends Component
{
    public int    $step           = 1;
    public string $email          = '';
    public string $otp            = '';
    public string $new_password   = '';
    public string $confirm_password = '';

    // Hold the matched user across steps
    public ?int $userId = null;

    // ── Step 1: Request OTP ───────────────────────────────────

    public function sendOtp(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        $user = User::where('email', $this->email)
            ->where('status', 'active')
            ->first();

        // Always show same message — don't reveal whether email exists
        if (! $user) {
            $this->dispatch('notify', type: 'info',
                message: 'If that email is registered, you will receive a reset code shortly.');
            return;
        }

        // Invalidate any previous unused OTPs for this user
        Otp::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        // Generate new OTP
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(15),
            'used'       => false,
        ]);

        // Send email
        try {
            Mail::html(
                view('emails.password-reset-otp', [
                    'user' => $user,
                    'code' => $code,
                ])->render(),
                fn($m) => $m->to($user->email)
                    ->subject('FlowDesk — Password Reset Code')
            );
        } catch (\Exception $e) {
            \Log::error("Password reset OTP email failed: " . $e->getMessage());
        }

        $this->userId = $user->id;
        $this->step   = 2;

        $this->dispatch('notify', type: 'success',
            message: 'A 6-digit reset code has been sent to your email.');
    }

    // ── Step 2: Verify OTP ────────────────────────────────────

    public function verifyOtp(): void
    {
        $this->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Please enter the 6-digit code.',
            'otp.digits'   => 'Code must be exactly 6 digits.',
        ]);

        $record = Otp::where('user_id', $this->userId)
            ->where('code', $this->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            $this->dispatch('notify', type: 'error',
                message: 'Invalid or expired code. Please try again.');
            return;
        }

        $record->update(['used' => true]);
        $this->step = 3;
    }

    public function resendOtp(): void
    {
        $this->step = 1;
        $this->otp  = '';
        $this->sendOtp();
    }

    // ── Step 3: Set new password ──────────────────────────────

    public function resetPassword(): void
    {
        $this->validate([
            'new_password'    => ['required', 'string', 'min:8',
                'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'confirm_password'=> ['required', 'same:new_password'],
        ], [
            'new_password.required'  => 'Please enter a new password.',
            'new_password.min'       => 'Password must be at least 8 characters.',
            'new_password.regex'     => 'Password must contain uppercase, number, and special character (@$!%*#?&).',
            'confirm_password.same'  => 'Passwords do not match.',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'password'              => Hash::make($this->new_password),
            'force_password_change' => false,
        ]);

        // Log it
        \App\Models\AuthLog::create([
            'user_id'         => $user->id,
            'email_attempted' => $user->email,
            'event'           => 'password_reset',
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
            'created_at'      => now(),
        ]);

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Password reset successfully. You can now log in.');

        $this->redirect(route('login'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.auth');
    }
}
