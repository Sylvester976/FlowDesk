<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Directorate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class StaffList extends Component
{
    use WithPagination;

    // Filters
    public string $search       = '';
    public string $filterRole   = '';
    public string $filterStatus = '';
    public string $filterDir    = '';
    public string $filterDept   = '';

    // Bulk actions
    public array $selected    = [];
    public bool $selectAll    = false;
    public string $bulkAction = '';

    // Confirm modal
    public bool $showConfirm    = false;
    public string $confirmText  = '';
    public string $pendingAction = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch(): void     { $this->resetPage(); }
    public function updatedFilterRole(): void  { $this->resetPage(); }
    public function updatedFilterStatus(): void{ $this->resetPage(); }
    public function updatedFilterDir(): void   { $this->resetPage(); $this->filterDept = ''; }

    public function updatedSelectAll(bool $val): void
    {
        $this->selected = $val
            ? $this->getQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray()
            : [];
    }

    // ── Query ──────────────────────────────────────────────

    private function getQuery()
    {
        return User::with(['role', 'department.directorate', 'supervisor'])
            ->when($this->search, fn($q) =>
                $q->where(fn($q) =>
                    $q->whereRaw("LOWER(first_name || ' ' || last_name) LIKE ?", ['%'.strtolower($this->search).'%'])
                      ->orWhere('email', 'ilike', '%'.$this->search.'%')
                      ->orWhere('pf_number', 'ilike', '%'.$this->search.'%')
                )
            )
            ->when($this->filterRole,   fn($q) => $q->where('role_id', $this->filterRole))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterDir, fn($q) =>
                $q->whereHas('department', fn($q) => $q->where('directorate_id', $this->filterDir))
            )
            ->when($this->filterDept,   fn($q) => $q->where('department_id', $this->filterDept))
            ->orderBy('first_name');
    }

    // ── Bulk actions ───────────────────────────────────────

    public function confirmBulk(): void
    {
        if (empty($this->selected)) {
            $this->dispatch('notify', type: 'warning', message: 'No staff selected.');
            return;
        }

        $count = count($this->selected);

        $this->confirmText = match($this->bulkAction) {
            'activate'        => "Activate {$count} staff member(s)?",
            'deactivate'      => "Deactivate {$count} staff member(s)?",
            'force_password'  => "Force password change for {$count} staff member(s)?",
            default           => ''
        };

        if ($this->confirmText) {
            $this->pendingAction = $this->bulkAction;
            $this->showConfirm   = true;
        }
    }

    public function executeBulk(): void
    {
        if (empty($this->selected)) return;

        // Prevent superadmin from being deactivated
        $safeIds = User::whereIn('id', $this->selected)
            ->whereHas('role', fn($q) => $q->where('is_system', false))
            ->pluck('id');

        match($this->pendingAction) {
            'activate'       => User::whereIn('id', $safeIds)->update(['status' => 'active']),
            'deactivate'     => User::whereIn('id', $safeIds)->update(['status' => 'inactive']),
            'force_password' => User::whereIn('id', $safeIds)->update(['force_password_change' => true]),
            default          => null
        };

        $this->dispatch('notify', type: 'success', message: 'Bulk action applied successfully.');
        $this->selected      = [];
        $this->selectAll     = false;
        $this->showConfirm   = false;
        $this->pendingAction = '';
        $this->bulkAction    = '';
    }

    // ── Single actions ─────────────────────────────────────

    public function toggleStatus(int $userId): void
    {
        $user = User::findOrFail($userId);

        if ($user->role?->is_system) {
            $this->dispatch('notify', type: 'error', message: 'Cannot change status of a system account.');
            return;
        }

        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function forcePasswordChange(int $userId): void
    {
        User::findOrFail($userId)->update(['force_password_change' => true]);
        $this->dispatch('notify', type: 'success', message: 'Password change will be required on next login.');
    }

    public function render()
    {
        $staff        = $this->getQuery()->paginate(15);
        $roles        = Role::orderBy('hierarchy_level')->get();
        $directorates = Directorate::where('is_active', true)->orderBy('name')->get();
        $departments  = $this->filterDir
            ? Department::where('directorate_id', $this->filterDir)->where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('livewire.admin.staff-list', compact('staff', 'roles', 'directorates', 'departments'))
            ->layout('components.layouts.app');
    }
}
