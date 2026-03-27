<?php

namespace App\Livewire\Auth;

use App\Models\AuthLog;
use App\Models\Otp;
use App\Models\User;
use App\Services\UserServiceClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Login extends Component
{
    public string $email    = '';
    public string $password = '';
    public bool   $remember = false;

    protected array $rules = [
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ];

    public function submit(UserServiceClient $client): void
    {
        $this->validate();

        $key = 'login:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            AuthLog::record('lockout', null, $this->email, "Too many attempts. Locked for {$seconds}s");
            $this->dispatch('notify', type: 'error', message: "Too many attempts. Wait {$seconds} seconds.");
            $this->addError('email', "Too many login attempts. Please wait {$seconds} seconds.");
            return;
        }

        $preAuthToken = null;
        $authMode     = 'local';
        $user         = null;

        // ── Try User Service first ────────────────────────────
        if ($client->isConfigured() && $client->isHealthy()) {

            $response = $client->login($this->email, $this->password);

            if ($response && isset($response['pre_auth_token'])) {
                // ✓ User Service authenticated successfully
                $preAuthToken = $response['pre_auth_token'];
                $authMode     = 'user_service';

                // Find local shadow record
                $user = User::where('email', $this->email)->first();

                // Not in FlowDesk yet — create shadow record on first login
                if (! $user && isset($response['user'])) {
                    $user = $this->createLocalShadow($response['user']);
                }

            } else {
                // User Service is reachable but rejected the credentials
                // Don't fall through to local — User Service is the authority
                RateLimiter::hit($key, 60);
                AuthLog::record('login_failed', null, $this->email, 'User Service rejected credentials');
                $this->dispatch('notify', type: 'error', message: 'Invalid email or password.');
                $this->addError('email', 'These credentials do not match our records.');
                return;
            }

        } else {
            // ── Local fallback — User Service is down ─────────
            Log::warning("User Service unreachable — local auth fallback for {$this->email}");

            $user = User::where('email', $this->email)->first();

            if (! $user || ! password_verify($this->password, $user->password)) {
                RateLimiter::hit($key, 60);
                AuthLog::record('login_failed', $user?->id, $this->email, 'Local fallback — invalid credentials');
                $this->dispatch('notify', type: 'error', message: 'Invalid email or password.');
                $this->addError('email', 'These credentials do not match our records.');
                return;
            }
        }

        // ── Common checks ─────────────────────────────────────
        if (! $user) {
            RateLimiter::hit($key, 60);
            $this->dispatch('notify', type: 'error', message: 'Invalid email or password.');
            $this->addError('email', 'These credentials do not match our records.');
            return;
        }

        if ($user->status !== 'active') {
            AuthLog::record('login_failed', $user->id, $this->email, 'Account inactive: ' . $user->status);
            $this->dispatch('notify', type: 'warning', message: 'Your account is not active. Contact the administrator.');
            $this->addError('email', 'Your account is not active.');
            return;
        }

        RateLimiter::clear($key);

        // ── FlowDesk OTP policy — always required ─────────────
        // User Service doesn't decide this — FlowDesk does
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

        try {
            Mail::html(
                view('emails.otp', ['user' => $user, 'code' => $code])->render(),
                fn($m) => $m->to($user->email)->subject('FlowDesk — Your Login Code')
            );
        } catch (\Exception $e) {
            Log::error("OTP email failed: " . $e->getMessage());
        }

        AuthLog::record('otp_sent', $user->id, $user->email, "Auth mode: {$authMode}");

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Code sent! Check your email.');

        session([
            'otp_user_id'   => $user->id,
            'otp_remember'  => $this->remember,
            'otp_pre_auth'  => $preAuthToken, // null if local fallback
            'otp_auth_mode' => $authMode,
        ]);

        $this->redirect(route('auth.otp'), navigate: false);
    }

    /**
     * Create a local shadow record for a user that exists in User Service
     * but has never logged into FlowDesk before.
     * HR will still need to assign their role and department.
     */
    private function createLocalShadow(array $remote): User
    {
        return User::create([
            'user_service_id'       => $remote['id'],
            'pf_number'             => $remote['pf_number'],
            'id_number'             => $remote['id_number'] ?? null,
            'first_name'            => $remote['first_name'],
            'last_name'             => $remote['last_name'],
            'email'                 => $remote['email'],
            'phone'                 => $remote['phone'] ?? null,
            'password'              => \Hash::make(\Str::random(32)),
            'status'                => 'active',
            'force_password_change' => false,
            'sync_status'           => 'synced',
            'sync_direction'        => 'linked',
            'last_synced_at'        => now(),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.auth');
    }
}
