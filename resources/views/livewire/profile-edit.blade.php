<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">My Profile</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Profile</span>
            </nav>
        </div>
    </div>

    <div class="row g-3">

        {{-- ── LEFT — Avatar + read-only info ──────────────── --}}
        <div class="col-12 col-lg-3">
            <div class="card mb-3">
                <div class="card-body text-center py-4">

                    {{-- Avatar --}}
                    <div class="position-relative d-inline-block mb-3">
                        @if($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}"
                            alt="{{ $user->full_name }}"
                            style="width:88px;height:88px;border-radius:50%;object-fit:cover;
                                border:3px solid #e8f0fb;">
                        @else
                        <div style="width:88px;height:88px;border-radius:50%;
                            background:#1a3a6b;color:#fff;
                            display:flex;align-items:center;justify-content:center;
                            font-size:1.8rem;font-weight:700;margin:0 auto;">
                            {{ strtoupper(substr($user->first_name,0,1).substr($user->last_name,0,1)) }}
                        </div>
                        @endif
                    </div>

                    <div class="fw-bold mb-0" style="font-size:1rem;">{{ $user->full_name }}</div>
                    <div class="text-muted mb-1" style="font-size:.8rem;">{{ $user->role?->label }}</div>
                    @if($user->jobTitle)
                    <div class="text-muted mb-2" style="font-size:.76rem;">{{ $user->jobTitle->name }}</div>
                    @endif

                    <span class="badge bg-success-subtle text-success border border-success-subtle mb-3"
                        style="font-size:.72rem;">Active</span>

                    {{-- Photo upload --}}
                    <div class="border-top pt-3">
                        <div class="mb-2">
                            <input type="file" wire:model="photo" id="photoInput"
                                class="d-none" accept="image/jpeg,image/png,image/webp">
                            <label for="photoInput"
                                class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-camera me-1"></i>
                                {{ $user->profile_photo ? 'Change Photo' : 'Upload Photo' }}
                            </label>
                        </div>
                        @error('photo')<div class="text-danger" style="font-size:.76rem;">{{ $message }}</div>@enderror
                        @if($photo)
                        <button wire:click="savePhoto" class="btn btn-sm btn-success w-100 mb-1"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Save Photo</span>
                            <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                        @endif
                        @if($user->profile_photo)
                        <button wire:click="removePhoto"
                            wire:confirm="Remove your profile photo?"
                            class="btn btn-sm btn-outline-danger w-100" style="font-size:.76rem;">
                            Remove
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Read-only employment info --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0" style="font-size:.84rem;">
                        <i class="bi bi-building me-1" style="color:#1a3a6b;"></i>Employment
                    </h6>
                </div>
                <div class="card-body p-0">
                    @php
                        $info = [
                            'PF Number'    => $user->pf_number,
                            'ID Number'    => $user->id_number,
                            'Email'        => $user->email,
                            'Division'     => $user->department?->name,
                            'Directorate'  => $user->department?->directorate?->name,
                            'Supervisor'   => $user->supervisor?->full_name,
                            'Appointed'    => $user->date_of_appointment?->format('d M Y'),
                        ];
                    @endphp
                    @foreach(array_filter($info) as $label => $value)
                    <div class="d-flex justify-content-between px-3 py-2
                        {{ !$loop->last ? 'border-bottom' : '' }}"
                        style="font-size:.78rem;">
                        <span class="text-muted">{{ $label }}</span>
                        <span class="fw-medium text-end ms-2" style="max-width:60%;">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── RIGHT — Tabs ─────────────────────────────────── --}}
        <div class="col-12 col-lg-9">

            {{-- Tabs --}}
            <div class="card mb-3">
                <div class="card-body py-2">
                    <ul class="nav nav-pills gap-1">
                        @foreach(['personal' => 'Personal Details', 'travel' => 'Travel Documents', 'password' => 'Change Password'] as $tab => $label)
                        <li class="nav-item">
                            <button wire:click="$set('activeTab', '{{ $tab }}')"
                                class="nav-link {{ $activeTab === $tab ? 'active' : '' }} py-1 px-3"
                                style="font-size:.84rem;">
                                {{ $label }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Personal details --}}
            @if($activeTab === 'personal')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person me-2" style="color:#1a3a6b;"></i>Personal Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">First Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="first_name"
                                class="form-control @error('first_name') is-invalid @enderror">
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Last Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="last_name"
                                class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Other Names</label>
                            <input type="text" wire:model="other_names" class="form-control"
                                placeholder="Middle name(s)">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Phone Number</label>
                            <input type="text" wire:model="phone" class="form-control"
                                placeholder="e.g. 0712 345 678">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Date of Birth</label>
                            <input type="date" wire:model="date_of_birth"
                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                max="{{ now()->subYears(18)->format('Y-m-d') }}">
                            @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button wire:click="savePersonal" class="btn btn-primary"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="bi bi-check-lg me-1"></i>Save Changes</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- Travel documents --}}
            @if($activeTab === 'travel')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-credit-card me-2" style="color:#1a3a6b;"></i>Travel Documents
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Passport Number</label>
                            <input type="text" wire:model="passport_number"
                                class="form-control @error('passport_number') is-invalid @enderror"
                                placeholder="e.g. AK1234567">
                            @error('passport_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Your ordinary/tourist passport.</div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Diplomatic Passport Number</label>
                            <input type="text" wire:model="diplomatic_passport_number"
                                class="form-control @error('diplomatic_passport_number') is-invalid @enderror"
                                placeholder="e.g. DP1234567">
                            @error('diplomatic_passport_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">If applicable.</div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded" style="background:#e8f0fb;font-size:.82rem;color:#374151;">
                                <i class="bi bi-info-circle me-1" style="color:#1a3a6b;"></i>
                                Keep your passport details up to date. They appear on your clearance letters
                                and post-trip documents.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button wire:click="saveTravelDocs" class="btn btn-primary"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="bi bi-check-lg me-1"></i>Save Documents</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- Password change --}}
            @if($activeTab === 'password')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2" style="color:#1a3a6b;"></i>Change Password
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Current Password <span class="text-danger">*</span></label>
                            <input type="password" wire:model="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12"></div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">New Password <span class="text-danger">*</span></label>
                            <input type="password" wire:model="new_password"
                                class="form-control @error('new_password') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-medium">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" wire:model="confirm_password"
                                class="form-control @error('confirm_password') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded" style="background:var(--bs-tertiary-bg);font-size:.82rem;">
                                <div class="fw-medium mb-1">Password requirements:</div>
                                <ul class="mb-0 ps-3" style="line-height:1.9;color:var(--bs-secondary-color);">
                                    <li>At least 8 characters</li>
                                    <li>At least one uppercase letter (A–Z)</li>
                                    <li>At least one number (0–9)</li>
                                    <li>At least one special character (@$!%*#?&)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button wire:click="changePassword" class="btn btn-primary"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="bi bi-shield-check me-1"></i>Update Password</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span>Updating...</span>
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</div>
