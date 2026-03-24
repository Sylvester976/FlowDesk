<?php

namespace App\Livewire\Admin;

use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class RolesManager extends Component
{
    // Role form
    public bool   $showRoleForm  = false;
    public ?int   $editingRoleId = null;
    public string $role_name     = '';
    public string $role_label    = '';
    public int    $role_level    = 9;
    public bool   $role_can_supervise = false;

    // Job title form
    public bool   $showTitleForm  = false;
    public ?int   $activeTitleRoleId = null;
    public string $activeTitleRoleName = '';
    public ?int   $editingTitleId = null;
    public string $title_name     = '';
    public bool   $title_is_default = false;

    // Permissions modal
    public bool   $showPermissionsModal = false;
    public ?int   $permUserId = null;
    public string $permUserName = '';
    public bool   $perm_is_superadmin = false;
    public bool   $perm_is_hr_admin   = false;

    // Confirm delete
    public bool   $showDeleteConfirm = false;
    public string $deleteType = '';
    public ?int   $deleteId   = null;
    public string $deleteLabel = '';

    // Permissions search
    public string $permSearch = '';

    // ── Role CRUD ─────────────────────────────────────────────

    public function openRoleForm(?int $roleId = null): void
    {
        $this->resetRoleForm();
        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $this->editingRoleId      = $role->id;
            $this->role_name          = $role->name;
            $this->role_label         = $role->label;
            $this->role_level         = $role->hierarchy_level;
            $this->role_can_supervise = $role->can_supervise;
        }
        $this->showRoleForm = true;
    }

    public function saveRole(): void
    {
        $this->validate([
            'role_name'  => ['required', 'string', 'max:50',
                'unique:roles,name' . ($this->editingRoleId ? ",{$this->editingRoleId}" : '')],
            'role_label' => ['required', 'string', 'max:100'],
            'role_level' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $data = [
            'name'            => $this->role_name,
            'label'           => $this->role_label,
            'hierarchy_level' => $this->role_level,
            'can_supervise'   => $this->role_can_supervise,
        ];

        if ($this->editingRoleId) {
            $role = Role::findOrFail($this->editingRoleId);
            $role->update($data);
            $this->dispatch('notify', type: 'success', message: "Role '{$role->label}' updated.");
        } else {
            Role::create(array_merge($data, ['is_ps' => false, 'is_system' => false]));
            $this->dispatch('notify', type: 'success', message: "Role '{$this->role_label}' created.");
        }

        $this->resetRoleForm();
    }

    public function confirmDeleteRole(int $roleId): void
    {
        $role = Role::findOrFail($roleId);

        if ($role->is_system) {
            $this->dispatch('notify', type: 'error', message: 'System roles cannot be deleted.');
            return;
        }

        if ($role->users()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: 'Cannot delete role — staff are assigned to it.');
            return;
        }

        $this->deleteType  = 'role';
        $this->deleteId    = $roleId;
        $this->deleteLabel = $role->label;
        $this->showDeleteConfirm = true;
    }

    public function executeDelete(): void
    {
        if ($this->deleteType === 'role') {
            Role::findOrFail($this->deleteId)->delete();
            $this->dispatch('notify', type: 'success', message: "Role '{$this->deleteLabel}' deleted.");
        } elseif ($this->deleteType === 'title') {
            JobTitle::findOrFail($this->deleteId)->delete();
            $this->dispatch('notify', type: 'success', message: "Job title deleted.");
        }
        $this->showDeleteConfirm = false;
    }

    private function resetRoleForm(): void
    {
        $this->showRoleForm      = false;
        $this->editingRoleId     = null;
        $this->role_name         = '';
        $this->role_label        = '';
        $this->role_level        = 9;
        $this->role_can_supervise = false;
    }

    // ── Job Title CRUD ────────────────────────────────────────

    public function openTitleForm(int $roleId, ?int $titleId = null): void
    {
        $role = Role::findOrFail($roleId);
        $this->activeTitleRoleId   = $roleId;
        $this->activeTitleRoleName = $role->label;
        $this->editingTitleId      = $titleId;
        $this->title_name          = '';
        $this->title_is_default    = false;

        if ($titleId) {
            $title = JobTitle::findOrFail($titleId);
            $this->title_name       = $title->name;
            $this->title_is_default = $title->is_default;
        }

        $this->showTitleForm = true;
    }

    public function saveTitle(): void
    {
        $this->validate([
            'title_name' => ['required', 'string', 'max:150'],
        ]);

        if ($this->editingTitleId) {
            JobTitle::findOrFail($this->editingTitleId)->update([
                'name'       => $this->title_name,
                'is_default' => $this->title_is_default,
            ]);
            $this->dispatch('notify', type: 'success', message: 'Job title updated.');
        } else {
            JobTitle::create([
                'role_id'    => $this->activeTitleRoleId,
                'name'       => $this->title_name,
                'is_default' => $this->title_is_default,
                'is_active'  => true,
            ]);
            $this->dispatch('notify', type: 'success', message: 'Job title added.');
        }

        $this->showTitleForm = false;
    }

    public function confirmDeleteTitle(int $titleId): void
    {
        $title = JobTitle::findOrFail($titleId);
        $this->deleteType  = 'title';
        $this->deleteId    = $titleId;
        $this->deleteLabel = $title->name;
        $this->showDeleteConfirm = true;
    }

    // ── Permissions ───────────────────────────────────────────

    public function openPermissions(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->permUserId        = $userId;
        $this->permUserName      = $user->full_name;
        $this->perm_is_superadmin = $user->is_superadmin;
        $this->perm_is_hr_admin   = $user->is_hr_admin;
        $this->showPermissionsModal = true;
    }

    public function savePermissions(): void
    {
        $user = User::findOrFail($this->permUserId);
        $user->update([
            'is_superadmin' => $this->perm_is_superadmin,
            'is_hr_admin'   => $this->perm_is_hr_admin,
        ]);

        $this->dispatch('notify', type: 'success', message: "Permissions updated for {$user->full_name}.");
        $this->showPermissionsModal = false;
    }

    public function render()
    {
        $roles = Role::with(['jobTitles', 'users'])
            ->orderBy('hierarchy_level')
            ->get();

        $permUsers = User::with('role')
            ->where('status', 'active')
            ->when($this->permSearch, fn($q) =>
                $q->whereRaw("LOWER(first_name || ' ' || last_name) LIKE ?",
                    ['%' . strtolower($this->permSearch) . '%'])
                  ->orWhere('email', 'ilike', '%' . $this->permSearch . '%')
            )
            ->orderBy('first_name')
            ->limit(20)
            ->get();

        return view('livewire.admin.roles-manager', compact('roles', 'permUsers'))
            ->layout('components.layouts.app');
    }
}
