<div>
    <div class="main-content page-staff">

        {{-- Page header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Staff Management</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <span class="breadcrumb-item active">Staff</span>
                </nav>
            </div>
            @if(auth()->user()->canManageUsers())
                <div class="page-header-actions">
                    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus me-1"></i>
                        <span class="d-none d-sm-inline">Add Staff</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body py-3">
                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                   class="form-control" placeholder="Search name, email, PF number...">
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <select wire:model.live="filterRole" class="form-select form-select-sm">
                            <option value="">All roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select wire:model.live="filterStatus" class="form-select form-select-sm">
                            <option value="">All status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select wire:model.live="filterDir" class="form-select form-select-sm">
                            <option value="">All directorates</option>
                            @foreach($directorates as $dir)
                                <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select wire:model.live="filterDept" class="form-select form-select-sm"
                                @if(!$filterDir) disabled @endif>
                            <option value="">All departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bulk actions (superadmin only) --}}
        @if(auth()->user()->isSuperAdmin())
            <div class="card mb-3" x-data x-show="$wire.selected.length > 0"
                 style="display:none!important;" x-cloak
                 x-bind:style="$wire.selected.length > 0 ? 'display:block!important' : 'display:none!important'">
                <div class="card-body py-2 d-flex align-items-center gap-3 flex-wrap">
            <span class="text-muted small fw-medium">
                <span x-text="$wire.selected.length"></span> selected
            </span>
                    <select wire:model="bulkAction" class="form-select form-select-sm" style="width:auto;">
                        <option value="">Choose action...</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="force_password">Force password change</option>
                    </select>
                    <button wire:click="confirmBulk" class="btn btn-sm btn-primary"
                            @if(!$bulkAction) disabled @endif>
                        Apply
                    </button>
                    <button wire:click="$set('selected', [])" class="btn btn-sm btn-outline-secondary">
                        Clear selection
                    </button>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            @if(auth()->user()->isSuperAdmin())
                                <th style="width:40px;">
                                    <input type="checkbox" wire:model.live="selectAll" class="form-check-input">
                                </th>
                            @endif
                            <th>Staff</th>
                            <th class="d-none d-md-table-cell">Role</th>
                            <th class="d-none d-lg-table-cell">Department</th>
                            <th class="d-none d-xl-table-cell">Supervisor</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Days used</th>
                            <th style="width:100px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($staff as $member)
                            <tr wire:key="staff-{{ $member->id }}">
                                @if(auth()->user()->isSuperAdmin())
                                    <td>
                                        <input type="checkbox" wire:model.live="selected"
                                               value="{{ $member->id }}" class="form-check-input"
                                               @if($member->role?->is_system) disabled @endif>
                                    </td>
                                @endif
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-initials-avatar"
                                             style="width:34px;height:34px;font-size:.7rem;flex-shrink:0;">
                                            {{ strtoupper(substr($member->first_name,0,1).substr($member->last_name,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium" style="font-size:.88rem;">
                                                {{ $member->full_name }}
                                                @if($member->force_password_change)
                                                    <span class="badge bg-warning text-dark ms-1"
                                                          style="font-size:.65rem;">
                                                    <i class="bi bi-key"></i> pwd
                                                </span>
                                                @endif
                                            </div>
                                            <div class="text-muted" style="font-size:.78rem;">{{ $member->email }}</div>
                                            @if($member->pf_number)
                                                <div class="text-muted" style="font-size:.74rem;">
                                                    PF: {{ $member->pf_number }}</div>
                                            @endif
                                            {{-- Mobile: show role + dept inline --}}
                                            <div class="d-md-none mt-1">
                                                <span class="badge bg-light text-dark border"
                                                      style="font-size:.7rem;">{{ $member->role?->label }}</span>
                                                @if($member->department)
                                                    <span class="text-muted"
                                                          style="font-size:.74rem;"> · {{ $member->department->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                <span class="badge bg-light text-dark border" style="font-size:.75rem;">
                                    {{ $member->role?->label ?? '—' }}
                                </span>
                                </td>
                                <td class="d-none d-lg-table-cell" style="font-size:.83rem;">
                                    @if($member->department)
                                        <div>{{ $member->department->name }}</div>
                                        <div class="text-muted"
                                             style="font-size:.75rem;">{{ $member->department->directorate?->name }}</div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="d-none d-xl-table-cell" style="font-size:.83rem;">
                                    {{ $member->supervisor?->full_name ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $badge = match($member->status) {
                                            'active'   => 'success',
                                            'inactive' => 'danger',
                                            default    => 'warning'
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badge }}-subtle text-{{ $badge }} border border-{{ $badge }}-subtle"
                                        style="font-size:.75rem;">
                                    {{ ucfirst($member->status) }}
                                </span>
                                </td>
                                <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                    {{ $member->days_used_this_year }} / {{ $member->max_days_per_year }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.staff.edit', $member->id) }}"
                                           class="btn btn-sm btn-outline-primary p-1" title="Edit"
                                           style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-pencil" style="font-size:.75rem;"></i>
                                        </a>
                                        @if(auth()->user()->isSuperAdmin() && ! $member->role?->is_system)
                                            <button wire:click="toggleStatus({{ $member->id }})"
                                                    class="btn btn-sm p-1 {{ $member->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    title="{{ $member->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;">
                                                <i class="bi {{ $member->status === 'active' ? 'bi-person-x' : 'bi-person-check' }}"
                                                   style="font-size:.75rem;"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-2 d-block mb-2"></i>
                                    No staff found matching your filters.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($staff->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing {{ $staff->firstItem() }}–{{ $staff->lastItem() }} of {{ $staff->total() }} staff
                    </div>
                    {{ $staff->links() }}
                </div>
            @endif
        </div>

        {{-- Confirm modal --}}
        @if($showConfirm)
            <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Action</h5>
                            <button wire:click="$set('showConfirm', false)" class="btn-close"></button>
                        </div>
                        <div class="modal-body">{{ $confirmText }}</div>
                        <div class="modal-footer">
                            <button wire:click="$set('showConfirm', false)" class="btn btn-outline-secondary btn-sm">
                                Cancel
                            </button>
                            <button wire:click="executeBulk" class="btn btn-primary btn-sm">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
