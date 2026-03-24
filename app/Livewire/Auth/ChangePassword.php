<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public string $password              = '';
    public string $password_confirmation = '';

    // Live requirement checks — updated as user types
    public bool $req_length    = false;
    public bool $req_uppercase = false;
    public bool $req_number    = false;
    public bool $req_special   = false;
    public bool $req_match     = false;

    public function updatedPassword(string $val): void
    {
        $this->req_length    = strlen($val) >= 8;
        $this->req_uppercase = (bool) preg_match('/[A-Z]/', $val);
        $this->req_number    = (bool) preg_match('/[0-9]/', $val);
        $this->req_special   = (bool) preg_match('/[@$!%*#?&]/', $val);
        $this->req_match     = $val !== '' && $val === $this->password_confirmation;
    }

    public function updatedPasswordConfirmation(string $val): void
    {
        $this->req_match = $val !== '' && $val === $this->password;
    }

    protected function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    protected $messages = [
        'password.min'       => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Passwords do not match.',
        'password.regex'     => 'Password must contain uppercase, number, and special character.',
    ];

    public function save(): void
    {
        // Check all requirements before validating
        if (! $this->req_length) {
            $this->dispatch('notify', type: 'error', message: 'Password must be at least 8 characters.');
            return;
        }
        if (! $this->req_uppercase) {
            $this->dispatch('notify', type: 'error', message: 'Password must contain at least one uppercase letter.');
            return;
        }
        if (! $this->req_number) {
            $this->dispatch('notify', type: 'error', message: 'Password must contain at least one number.');
            return;
        }
        if (! $this->req_special) {
            $this->dispatch('notify', type: 'error', message: 'Password must contain at least one special character (@$!%*#?&).');
            return;
        }
        if (! $this->req_match) {
            $this->dispatch('notify', type: 'error', message: 'Passwords do not match.');
            return;
        }

        $this->validate();

        auth()->user()->update([
            'password'              => Hash::make($this->password),
            'force_password_change' => false,
        ]);

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', 'Password set successfully. Welcome to FlowDesk!');

        $this->redirect(route('dashboard'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.change-password')
            ->layout('components.layouts.auth');
    }
}
