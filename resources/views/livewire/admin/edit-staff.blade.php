<div>
<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Staff Member</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <a href="{{ route('admin.staff.index') }}" class="breadcrumb-item">Staff</a>
                <span class="breadcrumb-item active">Edit — {{ $staff->full_name }}</span>
            </nav>
        </div>
        <div class="page-header-actions">
            {{-- Show force password change button --}}
            @if(auth()->user()->isSuperAdmin())
            <button type="button"
                wire:click="$dispatch('notify', {type: 'info', message: 'Use staff list to force password change.'})"
                class="btn btn-sm btn-outline-warning">
                <i class="bi bi-key me-1"></i>
                <span class="d-none d-sm-inline">Force Password Reset</span>
            </button>
            @endif
        </div>
    </div>

    {{-- Staff info banner --}}
    <div class="card mb-3 border-0" style="background:#e8f0fb;">
        <div class="card-body py-2">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="user-initials-avatar" style="width:42px;height:42px;font-size:.85rem;">
                    {{ strtoupper(substr($staff->first_name,0,1).substr($staff->last_name,0,1)) }}
                </div>
                <div>
                    <div class="fw-semibold" style="color:#1a3a6b;">{{ $staff->full_name }}</div>
                    <div class="text-muted" style="font-size:.78rem;">
                        {{ $staff->email }}
                        @if($staff->pf_number) · PF: {{ $staff->pf_number }} @endif
                        · Joined {{ $staff->created_at->format('M Y') }}
                    </div>
                </div>
                <div class="ms-auto">
                    <span class="badge {{ $staff->status === 'active' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                        {{ ucfirst($staff->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="save" novalidate>
        @include('livewire.admin._staff-form', ['isEdit' => true])
    </form>
</div>
</div>
