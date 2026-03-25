<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileEdit extends Component
{
    use WithFileUploads;

    // Personal info
    public string $first_name   = '';
    public string $last_name    = '';
    public string $other_names  = '';
    public string $phone        = '';
    public string $date_of_birth = '';

    // Travel docs
    public string $passport_number             = '';
    public string $diplomatic_passport_number  = '';

    // Photo
    public $photo = null;

    // Password change
    public string $current_password  = '';
    public string $new_password      = '';
    public string $confirm_password  = '';

    // Tab
    public string $activeTab = 'personal';

    public function mount(): void
    {
        $user = auth()->user();

        $this->first_name                  = $user->first_name;
        $this->last_name                   = $user->last_name;
        $this->other_names                 = $user->other_names ?? '';
        $this->phone                       = $user->phone ?? '';
        $this->date_of_birth               = $user->date_of_birth?->format('Y-m-d') ?? '';
        $this->passport_number             = $user->passport_number ?? '';
        $this->diplomatic_passport_number  = $user->diplomatic_passport_number ?? '';
    }

    public function savePersonal(): void
    {
        $this->validate([
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'other_names' => ['nullable', 'string', 'max:100'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
        ]);

        auth()->user()->update([
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'other_names'  => $this->other_names ?: null,
            'phone'        => $this->phone ?: null,
            'date_of_birth'=> $this->date_of_birth ?: null,
        ]);

        $this->dispatch('notify', type: 'success', message: 'Personal details updated.');
    }

    public function saveTravelDocs(): void
    {
        $this->validate([
            'passport_number'            => ['nullable', 'string', 'max:50'],
            'diplomatic_passport_number' => ['nullable', 'string', 'max:50'],
        ]);

        auth()->user()->update([
            'passport_number'            => $this->passport_number ?: null,
            'diplomatic_passport_number' => $this->diplomatic_passport_number ?: null,
        ]);

        $this->dispatch('notify', type: 'success', message: 'Travel documents updated.');
    }

    public function savePhoto(): void
    {
        $this->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        // Delete old photo
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $this->photo->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        $this->photo = null;
        $this->dispatch('notify', type: 'success', message: 'Profile photo updated.');
    }

    public function removePhoto(): void
    {
        $user = auth()->user();
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }
        $this->dispatch('notify', type: 'success', message: 'Profile photo removed.');
    }

    public function changePassword(): void
    {
        $this->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'min:8',
                'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'confirm_password' => ['required', 'same:new_password'],
        ], [
            'new_password.regex'        => 'Password must contain uppercase, number, and special character.',
            'new_password.min'          => 'Password must be at least 8 characters.',
            'confirm_password.same'     => 'Passwords do not match.',
        ]);

        $user = auth()->user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password'              => Hash::make($this->new_password),
            'force_password_change' => false,
        ]);

        $this->current_password = '';
        $this->new_password     = '';
        $this->confirm_password = '';

        $this->dispatch('notify', type: 'success', message: 'Password changed successfully.');
    }

    public function render()
    {
        return view('livewire.profile-edit', [
            'user' => auth()->user()->fresh(),
        ])->layout('components.layouts.app');
    }
}
