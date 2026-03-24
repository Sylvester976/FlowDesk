<div>
<div class="main-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Roles &amp; Hierarchy</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <a href="{{ route('admin.staff.index') }}" class="breadcrumb-item">Administration</a>
                <span class="breadcrumb-item active">Roles &amp; Hierarchy</span>
            </nav>
        </div>
        @if(auth()->user()->isSuperAdmin())
        <div class="page-header-actions">
            <button wire:click="openRoleForm()" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i>
                <span class="d-none d-sm-inline">Add Role</span>
            </button>
        </div>
        @endif
    </div>

    {{-- ── Roles + Job Titles ───────────────────────────────── --}}
    <div class="row g-3 mb-4">
        @foreach($roles as $role)
        <div class="col-12 col-lg-6" wire:key="role-{{ $role->id }}">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    {{-- Level badge --}}
                    <span class="badge rounded-pill"
                        style="background:#1a3a6b;color:#fff;font-size:.72rem;min-width:26px;">
                        L{{ $role->hierarchy_level }}
                    </span>
                    <h5 class="card-title mb-0 flex-grow-1">{{ $role->label }}</h5>
                    <div class="d-flex align-items-center gap-1">
                        @if($role->can_supervise)
                            <span class="badge bg-success-subtle text-success border border-success-subtle"
                                style="font-size:.7rem;">supervises</span>
                        @endif
                        @if($role->is_ps)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle"
                                style="font-size:.7rem;">PS</span>
                        @endif
                        @if(auth()->user()->isSuperAdmin() && ! $role->is_system)
                        <button wire:click="openRoleForm({{ $role->id }})"
                            class="btn btn-sm btn-outline-secondary p-1"
                            style="width:26px;height:26px;display:flex;align-items:center;justify-content:center;"
                            title="Edit role">
                            <i class="bi bi-pencil" style="font-size:.72rem;"></i>
                        </button>
                        <button wire:click="confirmDeleteRole({{ $role->id }})"
                            class="btn btn-sm btn-outline-danger p-1"
                            style="width:26px;height:26px;display:flex;align-items:center;justify-content:center;"
                            title="Delete role">
                            <i class="bi bi-trash" style="font-size:.72rem;"></i>
                        </button>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted" style="font-size:.78rem;">
                            <i class="bi bi-people me-1"></i>
                            {{ $role->users_count ?? $role->users->count() }} staff assigned
                        </span>
                        @if(auth()->user()->isSuperAdmin())
                        <button wire:click="openTitleForm({{ $role->id }})"
                            class="btn btn-sm btn-outline-primary py-0 px-2"
                            style="font-size:.75rem;">
                            <i class="bi bi-plus me-1"></i>Add title
                        </button>
                        @endif
                    </div>

                    {{-- Job titles --}}
                    @if($role->jobTitles->count())
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($role->jobTitles->sortBy('name') as $title)
                        <span class="badge d-inline-flex align-items-center gap-1"
                            style="background:#f0f4ff;color:#1a3a6b;border:1px solid #c8d8f8;font-size:.74rem;font-weight:400;">
                            @if($title->is_default)
                                <i class="bi bi-star-fill" style="font-size:.6rem;color:#c8a951;"></i>
                            @endif
                            {{ $title->name }}
                            @if(auth()->user()->isSuperAdmin())
                            <span style="cursor:pointer;margin-left:2px;"
                                wire:click="openTitleForm({{ $role->id }}, {{ $title->id }})"
                                title="Edit">
                                <i class="bi bi-pencil" style="font-size:.6rem;"></i>
                            </span>
                            <span style="cursor:pointer;color:#dc3545;"
                                wire:click="confirmDeleteTitle({{ $title->id }})"
                                title="Delete">
                                <i class="bi bi-x" style="font-size:.75rem;"></i>
                            </span>
                            @endif
                        </span>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted mb-0" style="font-size:.78rem;">No job titles yet.</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Permissions management ───────────────────────────── --}}
    @if(auth()->user()->isSuperAdmin())
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-shield-lock me-2 text-primary"></i>System Permissions
            </h5>
            <div class="card-actions">
                <div class="input-group input-group-sm" style="width:220px;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="permSearch"
                        class="form-control" placeholder="Search staff...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Staff</th>
                            <th class="d-none d-md-table-cell">Role</th>
                            <th class="d-none d-md-table-cell">Division</th>
                            <th>Superadmin</th>
                            <th>HR Admin</th>
                            <th style="width:80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permUsers as $u)
                        <tr wire:key="perm-{{ $u->id }}">
                            <td>
                                <div class="fw-medium" style="font-size:.85rem;">{{ $u->full_name }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $u->email }}</div>
                                {{-- Mobile role/dept --}}
                                <div class="d-md-none mt-1">
                                    <span class="badge bg-light text-dark border" style="font-size:.7rem;">
                                        {{ $u->role?->label }}
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                {{ $u->role?->label ?? '—' }}
                            </td>
                            <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                {{ $u->department?->name ?? '—' }}
                            </td>
                            <td>
                                @if($u->is_superadmin)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle"
                                        style="font-size:.75rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Yes
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size:.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($u->is_hr_admin)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"
                                        style="font-size:.75rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i>Yes
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size:.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="openPermissions({{ $u->id }})"
                                    class="btn btn-sm btn-outline-primary py-0 px-2"
                                    style="font-size:.75rem;">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No staff found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ── Role form modal ──────────────────────────────────────── --}}
@if($showRoleForm)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $editingRoleId ? 'Edit Role' : 'Add Role' }}</h5>
                <button wire:click="resetRoleForm" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Role name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="role_name"
                            class="form-control @error('role_name') is-invalid @enderror"
                            placeholder="e.g. principal_officer">
                        @error('role_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Lowercase, underscores only.</div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Display label <span class="text-danger">*</span></label>
                        <input type="text" wire:model="role_label"
                            class="form-control @error('role_label') is-invalid @enderror"
                            placeholder="e.g. Principal Officer">
                        @error('role_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label fw-medium">Hierarchy level <span class="text-danger">*</span></label>
                        <input type="number" wire:model="role_level" min="1" max="20"
                            class="form-control @error('role_level') is-invalid @enderror">
                        <div class="form-text">Lower = higher in org. PS = 1.</div>
                        @error('role_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6 d-flex align-items-end pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                wire:model="role_can_supervise" id="canSupervise">
                            <label class="form-check-label" for="canSupervise">
                                Can supervise others
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showRoleForm', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="saveRole" class="btn btn-primary btn-sm"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Role</span>
                    <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Job title form modal ─────────────────────────────────── --}}
@if($showTitleForm)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $editingTitleId ? 'Edit' : 'Add' }} Job Title
                    <small class="text-muted fw-normal">— {{ $activeTitleRoleName }}</small>
                </h5>
                <button wire:click="$set('showTitleForm', false)" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-medium">Job title <span class="text-danger">*</span></label>
                    <input type="text" wire:model="title_name"
                        class="form-control @error('title_name') is-invalid @enderror"
                        placeholder="e.g. ICT Officer I">
                    @error('title_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        wire:model="title_is_default" id="titleDefault">
                    <label class="form-check-label" for="titleDefault">
                        Set as default for this role
                        <small class="text-muted d-block">Default title is pre-selected when HR creates staff at this role level.</small>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showTitleForm', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="saveTitle" class="btn btn-primary btn-sm"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Save</span>
                    <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Permissions modal ────────────────────────────────────── --}}
@if($showPermissionsModal)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Permissions — {{ $permUserName }}
                </h5>
                <button wire:click="$set('showPermissionsModal', false)" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="p-3 rounded mb-3" style="background:#fff8e1;border-left:4px solid #c8a951;">
                    <p class="mb-0" style="font-size:.82rem;color:#78620a;">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        These permissions override the user's role. Grant with care.
                    </p>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox"
                        wire:model="perm_is_superadmin" id="permSA" role="switch">
                    <label class="form-check-label fw-medium" for="permSA">
                        Superadmin
                        <small class="text-muted d-block fw-normal">Full system access — all staff, all applications, all settings.</small>
                    </label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                        wire:model="perm_is_hr_admin" id="permHR" role="switch">
                    <label class="form-check-label fw-medium" for="permHR">
                        HR Admin
                        <small class="text-muted d-block fw-normal">Can create and manage staff accounts regardless of role.</small>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="$set('showPermissionsModal', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="savePermissions" class="btn btn-primary btn-sm"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Permissions</span>
                    <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Delete confirm modal ─────────────────────────────────── --}}
@if($showDeleteConfirm)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-trash me-2"></i>Delete
                </h5>
            </div>
            <div class="modal-body">
                <p class="mb-0">Delete <strong>{{ $deleteLabel }}</strong>? This cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button wire:click="$set('showDeleteConfirm', false)"
                    class="btn btn-outline-secondary btn-sm">Cancel</button>
                <button wire:click="executeDelete"
                    class="btn btn-danger btn-sm" wire:loading.attr="disabled">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>
