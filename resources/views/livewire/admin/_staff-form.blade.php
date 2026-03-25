{{--
    Shared staff form partial.
    Used by create-staff.blade.php and edit-staff.blade.php.
    Expects: $roles, $directorates, $allStaff, $isEdit (bool)
--}}

<div class="row g-3">

    {{-- ── LEFT COLUMN ────────────────────────────────────────── --}}
    <div class="col-12 col-lg-8">

        {{-- Personal details --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person me-2" style="color:#1a3a6b;"></i>Personal Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-4">
                        <label class="form-label fw-medium">First Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               placeholder="John">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label fw-medium">Last Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               placeholder="Doe">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="form-label fw-medium">Other Names</label>
                        <input type="text" wire:model="other_names"
                               class="form-control @error('other_names') is-invalid @enderror"
                               placeholder="Middle name(s)">
                        @error('other_names')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Official Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="john.doe@ict.go.ke">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Phone</label>
                        <input type="text" wire:model="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               placeholder="+254 7XX XXX XXX">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Date of Birth</label>
                        <input type="date" wire:model="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               min="{{ now()->subYears(60)->format('Y-m-d') }}"
                               max="{{ now()->subYears(18)->format('Y-m-d') }}">
                        @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Age must be between 18 and 60 years.</div>
                            @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Date of Appointment</label>
                        <input type="date" wire:model="date_of_appointment"
                               class="form-control @error('date_of_appointment') is-invalid @enderror"
                               max="{{ now()->format('Y-m-d') }}">
                        @error('date_of_appointment')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Identity & Employment --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-card-text me-2" style="color:#1a3a6b;"></i>Identity &amp; Employment
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">National ID Number</label>
                        <input type="text" wire:model="id_number"
                               class="form-control @error('id_number') is-invalid @enderror"
                               placeholder="12345678">
                        @error('id_number')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">PF Number</label>
                        <input type="text" wire:model="pf_number"
                               class="form-control @error('pf_number') is-invalid @enderror"
                               placeholder="PF-00001">
                        @error('pf_number')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">
                            Passport Number
                            <span class="text-muted fw-normal" style="font-size:.78rem;">(optional)</span>
                        </label>
                        <input type="text" wire:model="passport_number"
                               class="form-control @error('passport_number') is-invalid @enderror"
                               placeholder="A1234567">
                        @error('passport_number')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Required for foreign travel applications.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Organisation Placement --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-diagram-3 me-2" style="color:#1a3a6b;"></i>Organisation Placement
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- Step 1: Role --}}
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Role <span class="text-danger">*</span></label>
                        <select wire:model.live="role_id"
                                class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">Select role...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    L{{ $role->hierarchy_level }} — {{ $role->label }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Step 2: Job Title (filtered by role) --}}
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Job Title</label>
                        <select wire:model="job_title_id"
                                class="form-select"
                                @if(empty($jobTitles)) disabled @endif>
                            <option value="">
                                {{ empty($jobTitles) ? 'Select role first...' : 'Select job title...' }}
                            </option>
                            @foreach($jobTitles as $title)
                                <option value="{{ $title['id'] }}">
                                    {{ $title['name'] }}
                                    @if($title['is_default'])
                                        ★
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Filtered by selected role.</div>
                    </div>

                    {{-- Step 3: Directorate --}}
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Directorate</label>
                        <select wire:model.live="directorate_id" class="form-select">
                            <option value="">Select directorate...</option>
                            @foreach($directorates as $dir)
                                <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Step 4: Division (filtered by directorate) --}}
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Division</label>
                        <select wire:model.live="department_id"
                                class="form-select @error('department_id') is-invalid @enderror"
                                @if(empty($departments)) disabled @endif>
                            <option value="">
                                {{ empty($departments) ? 'Select directorate first...' : 'Select division...' }}
                            </option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept['id'] }}">{{ $dept['name'] }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Step 5: Supervisor (filtered by role level map) --}}
                    <div class="col-12">
                        <label class="form-label fw-medium">Supervisor / Reporting Line</label>
                        <select wire:model="supervisor_id"
                                class="form-select @error('supervisor_id') is-invalid @enderror"
                                @if(empty($supervisors)) disabled @endif>
                            <option value="">
                                @if(! $role_id)
                                    Select role first...
                                @elseif(empty($supervisors))
                                    No supervisor (top of chain)
                                @else
                                    Select supervisor...
                                @endif
                            </option>
                            @foreach($supervisors as $sup)
                                <option value="{{ $sup['id'] }}">
                                    {{ $sup['name'] }}
                                    @if($sup['pf_number'])
                                        ({{ $sup['pf_number'] }})
                                    @endif
                                    @if($sup['same_dept'])
                                        ← same division
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('supervisor_id')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($role_id && empty($supervisors))
                            @php $role = $roles->firstWhere('id', $role_id); @endphp
                            @if($role && $role->hierarchy_level === 1)
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Principal Secretary has no supervisor — top of the chain.
                                </div>
                            @else
                                <div class="form-text text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    No eligible supervisors found. For an Officer, the supervisor must be
                                    an <strong>Assistant Director</strong>. Create one first, then assign
                                    the supervisor here or via edit.
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Attached to (matrix reporting) --}}
                    <div class="col-12">
                        <label class="form-label fw-medium">
                            Attached To
                            <span class="text-muted fw-normal"
                                  style="font-size:.78rem;">(optional — for secondment)</span>
                        </label>
                        <select wire:model="attached_to_id" class="form-select">
                            <option value="">Not attached / seconded</option>
                            @foreach($allStaff as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->first_name }} {{ $s->last_name }}
                                    ({{ $s->role?->label }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            Use for staff working in the PS office or seconded to another unit.
                            Travel concurrence still uses the supervisor above.
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- ── RIGHT COLUMN ────────────────────────────────────────── --}}
    <div class="col-12 col-lg-4">

        {{-- Status (edit only) --}}
        @if($isEdit)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-toggle-on me-2" style="color:#1a3a6b;"></i>Account Status
                    </h5>
                </div>
                <div class="card-body">
                    <select wire:model="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
        @endif

        {{-- Travel settings --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-airplane me-2" style="color:#1a3a6b;"></i>Travel Settings
                </h5>
            </div>
            <div class="card-body">
                <label class="form-label fw-medium">Max Foreign Travel Days / Year</label>
                <input type="number" wire:model="max_days_per_year"
                       class="form-control @error('max_days_per_year') is-invalid @enderror"
                       min="0" max="365">
                @error('max_days_per_year')
                <div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Default: 30. Only foreign official travel counts.</div>
            </div>
        </div>

        {{-- Permissions (superadmin only) --}}
        @if(auth()->user()->isSuperAdmin())
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2" style="color:#bb0000;"></i>System Permissions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="p-2 rounded mb-3" style="background:#fff8e1;border-left:3px solid #c8a951;">
                        <p class="mb-0" style="font-size:.78rem;color:#78620a;">
                            Grant with care — permissions override role restrictions.
                        </p>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox"
                               wire:model="is_superadmin" id="isSuperAdmin" role="switch">
                        <label class="form-check-label" for="isSuperAdmin">
                            <span class="fw-medium">Superadmin</span>
                            <small class="text-muted d-block">Full system access</small>
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               wire:model="is_hr_admin" id="isHRAdmin" role="switch">
                        <label class="form-check-label" for="isHRAdmin">
                            <span class="fw-medium">HR Admin</span>
                            <small class="text-muted d-block">Staff management access</small>
                        </label>
                    </div>
                </div>
            </div>
        @endif

        {{-- Info / Submit --}}
        @if(! $isEdit)
            <div class="card mb-3 border-0" style="background:#e8f0fb;">
                <div class="card-body">
                    <h6 class="fw-semibold mb-2" style="color:#1a3a6b;font-size:.85rem;">
                        <i class="bi bi-info-circle me-1"></i>Account creation
                    </h6>
                    <ul class="mb-0 ps-3" style="font-size:.8rem;color:#374151;line-height:1.9;">
                        <li>Secure password auto-generated</li>
                        <li>Login credentials emailed to staff</li>
                        <li>Staff must change password on first login</li>
                        <li>Account set to <strong>Active</strong> immediately</li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="bi bi-{{ $isEdit ? 'check-lg' : 'person-plus' }} me-1"></i>
                    {{ $isEdit ? 'Save Changes' : 'Create Staff Member' }}
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    {{ $isEdit ? 'Saving...' : 'Creating...' }}
                </span>
            </button>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </div>
</div>
