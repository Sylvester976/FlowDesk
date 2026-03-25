<div>
    <div class="main-content">

        <div class="page-header">
            <div>
                <h1 class="page-title">Org Structure</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                    <a href="{{ route('admin.staff.index') }}" class="breadcrumb-item">Administration</a>
                    <span class="breadcrumb-item active">Org Structure</span>
                </nav>
            </div>
            <div class="page-header-actions">
                @if($tab === 'directorates')
                    <button wire:click="openDirForm()" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>
                        <span class="d-none d-sm-inline">Add Directorate</span>
                    </button>
                @else
                    <button wire:click="openDeptForm()" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>
                        <span class="d-none d-sm-inline">Add Division</span>
                    </button>
                @endif
            </div>
        </div>

        {{-- Tabs --}}
        <div class="card mb-3">
            <div class="card-body py-2 px-3">
                <ul class="nav nav-pills gap-1" style="flex-wrap:nowrap;">
                    <li class="nav-item">
                        <button wire:click="$set('tab', 'directorates')"
                                class="nav-link {{ $tab === 'directorates' ? 'active' : '' }} py-1 px-3"
                                style="font-size:.85rem;">
                            <i class="bi bi-building me-1"></i>
                            Directorates
                            <span class="badge bg-secondary ms-1" style="font-size:.68rem;">
                            {{ $directorates->count() }}
                        </span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button wire:click="$set('tab', 'divisions')"
                                class="nav-link {{ $tab === 'divisions' ? 'active' : '' }} py-1 px-3"
                                style="font-size:.85rem;">
                            <i class="bi bi-diagram-3 me-1"></i>
                            Divisions
                            <span class="badge bg-secondary ms-1" style="font-size:.68rem;">
                            {{ $departments->count() }}
                        </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        {{-- ── Directorates tab ─────────────────────────────────── --}}
        @if($tab === 'directorates')
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Directorates</h5>
                    <div class="card-actions">
                        <div class="input-group input-group-sm" style="width:200px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="searchDir"
                                   class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Directorate</th>
                                <th class="d-none d-md-table-cell">Code</th>
                                <th class="d-none d-lg-table-cell">Head</th>
                                <th class="d-none d-md-table-cell">Divisions</th>
                                <th>Status</th>
                                <th style="width:100px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($directorates as $dir)
                                <tr wire:key="dir-{{ $dir->id }}">
                                    <td>
                                        <div class="fw-medium" style="font-size:.88rem;">{{ $dir->name }}</div>
                                        {{-- Mobile extras --}}
                                        <div class="d-md-none text-muted" style="font-size:.75rem;">
                                            {{ $dir->departments_count }} division(s)
                                            @if($dir->code)
                                                · {{ $dir->code }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <code style="font-size:.78rem;">{{ $dir->code ?? '—' }}</code>
                                    </td>
                                    <td class="d-none d-lg-table-cell" style="font-size:.83rem;">
                                        {{ $dir->head?->full_name ?? '—' }}
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                        <button wire:click="$set('tab', 'divisions')"
                                                class="btn btn-link p-0 text-decoration-none"
                                                style="font-size:.83rem;">
                                            {{ $dir->departments_count }}
                                            <i class="bi bi-chevron-right" style="font-size:.7rem;"></i>
                                        </button>
                                    </td>
                                    <td>
                                <span
                                    class="badge {{ $dir->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }}"
                                    style="font-size:.75rem;">
                                    {{ $dir->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button wire:click="openDirForm({{ $dir->id }})"
                                                    class="btn btn-sm btn-outline-primary p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="Edit">
                                                <i class="bi bi-pencil" style="font-size:.75rem;"></i>
                                            </button>
                                            <button wire:click="toggleDirStatus({{ $dir->id }})"
                                                    class="btn btn-sm {{ $dir->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="{{ $dir->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi {{ $dir->is_active ? 'bi-pause' : 'bi-play' }}"
                                                   style="font-size:.75rem;"></i>
                                            </button>
                                            <button wire:click="confirmDeleteDir({{ $dir->id }})"
                                                    class="btn btn-sm btn-outline-danger p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="Delete">
                                                <i class="bi bi-trash" style="font-size:.75rem;"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-building fs-2 d-block mb-2"></i>
                                        No directorates found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── Divisions tab ────────────────────────────────────── --}}
        @if($tab === 'divisions')
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Divisions</h5>
                    <div class="card-actions">
                        <div class="input-group input-group-sm" style="width:200px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="searchDept"
                                   class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Division</th>
                                <th class="d-none d-md-table-cell">Directorate</th>
                                <th class="d-none d-lg-table-cell">Head</th>
                                <th class="d-none d-md-table-cell">Code</th>
                                <th>Status</th>
                                <th style="width:130px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($departments as $dept)
                                <tr wire:key="dept-{{ $dept->id }}">
                                    <td>
                                        <div class="fw-medium" style="font-size:.88rem;">{{ $dept->name }}</div>
                                        {{-- Mobile extras --}}
                                        <div class="d-md-none text-muted" style="font-size:.75rem;">
                                            {{ $dept->directorate?->name ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size:.83rem;">
                                <span class="badge bg-light text-dark border" style="font-size:.74rem;">
                                    {{ $dept->directorate?->name ?? '—' }}
                                </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell" style="font-size:.83rem;">
                                        {{ $dept->head?->full_name ?? '—' }}
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <code style="font-size:.78rem;">{{ $dept->code ?? '—' }}</code>
                                    </td>
                                    <td>
                                <span
                                    class="badge {{ $dept->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }}"
                                    style="font-size:.75rem;">
                                    {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button wire:click="openDeptForm({{ $dept->id }})"
                                                    class="btn btn-sm btn-outline-primary p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="Edit">
                                                <i class="bi bi-pencil" style="font-size:.75rem;"></i>
                                            </button>
                                            <button wire:click="openDeptForm(null, {{ $dept->directorate_id }})"
                                                    class="btn btn-sm btn-outline-secondary p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="Add division to same directorate">
                                                <i class="bi bi-plus" style="font-size:.75rem;"></i>
                                            </button>
                                            <button wire:click="toggleDeptStatus({{ $dept->id }})"
                                                    class="btn btn-sm {{ $dept->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="{{ $dept->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi {{ $dept->is_active ? 'bi-pause' : 'bi-play' }}"
                                                   style="font-size:.75rem;"></i>
                                            </button>
                                            <button wire:click="confirmDeleteDept({{ $dept->id }})"
                                                    class="btn btn-sm btn-outline-danger p-1"
                                                    style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;"
                                                    title="Delete">
                                                <i class="bi bi-trash" style="font-size:.75rem;"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-diagram-3 fs-2 d-block mb-2"></i>
                                        No divisions found.
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

    {{-- ── Directorate form modal ───────────────────────────────── --}}
    @if($showDirForm)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingDirId ? 'Edit Directorate' : 'Add Directorate' }}</h5>
                        <button wire:click="$set('showDirForm', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-medium">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="dir_name"
                                       class="form-control @error('dir_name') is-invalid @enderror"
                                       placeholder="e.g. Digital Infrastructure">
                                @error('dir_name')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-4">
                                <label class="form-label fw-medium">Code</label>
                                <input type="text" wire:model="dir_code"
                                       class="form-control @error('dir_code') is-invalid @enderror"
                                       placeholder="e.g. DI">
                                @error('dir_code')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-8">
                                <label class="form-label fw-medium">Head (Secretary)</label>
                                <select wire:model="dir_head_id" class="form-select">
                                    <option value="">Not assigned</option>
                                    @forelse($dirHeads as $h)
                                        <option value="{{ $h->id }}">{{ $h->full_name }}</option>
                                    @empty
                                        <option disabled>No Secretaries created yet</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('showDirForm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="saveDir" class="btn btn-primary btn-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading><span
                                    class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Division form modal ──────────────────────────────────── --}}
    @if($showDeptForm)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingDeptId ? 'Edit Division' : 'Add Division' }}</h5>
                        <button wire:click="$set('showDeptForm', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-medium">Division name <span
                                        class="text-danger">*</span></label>
                                <input type="text" wire:model="dept_name"
                                       class="form-control @error('dept_name') is-invalid @enderror"
                                       placeholder="e.g. ICT Connectivity">
                                @error('dept_name')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-4">
                                <label class="form-label fw-medium">Code</label>
                                <input type="text" wire:model="dept_code"
                                       class="form-control @error('dept_code') is-invalid @enderror"
                                       placeholder="e.g. DI-CON">
                                @error('dept_code')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-sm-8">
                                <label class="form-label fw-medium">Directorate <span
                                        class="text-danger">*</span></label>
                                <select wire:model="dept_dir_id"
                                        class="form-select @error('dept_dir_id') is-invalid @enderror">
                                    <option value="">Select directorate...</option>
                                    @foreach($allDirectorates as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                                @error('dept_dir_id')
                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Head (Director)</label>
                                <select wire:model="dept_head_id" class="form-select">
                                    <option value="">Not assigned</option>
                                    @forelse($deptHeads as $h)
                                        <option value="{{ $h->id }}">{{ $h->full_name }}</option>
                                    @empty
                                        <option disabled>No Directors created yet</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('showDeptForm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="saveDept" class="btn btn-primary btn-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save</span>
                            <span wire:loading><span
                                    class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Confirm modal ────────────────────────────────────────── --}}
    @if($showConfirm)
        <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.5);">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title text-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Delete <strong>{{ $confirmLabel }}</strong>? This cannot be undone.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button wire:click="$set('showConfirm', false)"
                                class="btn btn-outline-secondary btn-sm">Cancel
                        </button>
                        <button wire:click="executeConfirm"
                                class="btn btn-danger btn-sm" wire:loading.attr="disabled">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
