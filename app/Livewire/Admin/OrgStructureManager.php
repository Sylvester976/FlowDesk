<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Directorate;
use App\Models\User;
use Livewire\Component;

class OrgStructureManager extends Component
{
    // Active tab
    public string $tab = 'directorates';

    // Directorate form
    public bool   $showDirForm    = false;
    public ?int   $editingDirId   = null;
    public string $dir_name       = '';
    public string $dir_code       = '';
    public ?int   $dir_head_id    = null;

    // Division form
    public bool   $showDeptForm   = false;
    public ?int   $editingDeptId  = null;
    public string $dept_name      = '';
    public string $dept_code      = '';
    public ?int   $dept_dir_id    = null;
    public ?int   $dept_head_id   = null;

    // Confirm
    public bool   $showConfirm    = false;
    public string $confirmType    = '';
    public ?int   $confirmId      = null;
    public string $confirmLabel   = '';
    public string $confirmAction  = '';

    // Search
    public string $searchDir  = '';
    public string $searchDept = '';

    // ── Directorate CRUD ──────────────────────────────────────

    public function openDirForm(?int $id = null): void
    {
        $this->resetDirForm();
        if ($id) {
            $dir = Directorate::findOrFail($id);
            $this->editingDirId = $dir->id;
            $this->dir_name     = $dir->name;
            $this->dir_code     = $dir->code ?? '';
            $this->dir_head_id  = $dir->head_user_id;
        }
        $this->showDirForm = true;
    }

    public function saveDir(): void
    {
        $this->validate([
            'dir_name' => ['required', 'string', 'max:150'],
            'dir_code' => ['nullable', 'string', 'max:20',
                'unique:directorates,code' . ($this->editingDirId ? ",{$this->editingDirId}" : '')],
            'dir_head_id' => ['nullable', 'exists:users,id'],
        ]);

        $data = [
            'name'         => $this->dir_name,
            'code'         => $this->dir_code ?: null,
            'head_user_id' => $this->dir_head_id,
        ];

        if ($this->editingDirId) {
            Directorate::findOrFail($this->editingDirId)->update($data);
            $this->dispatch('notify', type: 'success', message: "Directorate updated.");
        } else {
            Directorate::create(array_merge($data, ['is_active' => true]));
            $this->dispatch('notify', type: 'success', message: "Directorate '{$this->dir_name}' created.");
        }

        $this->resetDirForm();
    }

    public function toggleDirStatus(int $id): void
    {
        $dir = Directorate::findOrFail($id);
        $dir->update(['is_active' => ! $dir->is_active]);
        $status = $dir->is_active ? 'activated' : 'deactivated';
        $this->dispatch('notify', type: 'success', message: "Directorate {$status}.");
    }

    public function confirmDeleteDir(int $id): void
    {
        $dir = Directorate::findOrFail($id);
        if ($dir->departments()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: 'Cannot delete — divisions exist under this directorate.');
            return;
        }
        $this->confirmType   = 'dir';
        $this->confirmId     = $id;
        $this->confirmLabel  = $dir->name;
        $this->confirmAction = 'delete';
        $this->showConfirm   = true;
    }

    private function resetDirForm(): void
    {
        $this->showDirForm  = false;
        $this->editingDirId = null;
        $this->dir_name     = '';
        $this->dir_code     = '';
        $this->dir_head_id  = null;
    }

    // ── Division CRUD ─────────────────────────────────────────

    public function openDeptForm(?int $id = null, ?int $dirId = null): void
    {
        $this->resetDeptForm();
        if ($id) {
            $dept = Department::findOrFail($id);
            $this->editingDeptId = $dept->id;
            $this->dept_name     = $dept->name;
            $this->dept_code     = $dept->code ?? '';
            $this->dept_dir_id   = $dept->directorate_id;
            $this->dept_head_id  = $dept->head_user_id;
        } elseif ($dirId) {
            $this->dept_dir_id = $dirId;
        }
        $this->showDeptForm = true;
    }

    public function saveDept(): void
    {
        $this->validate([
            'dept_name'   => ['required', 'string', 'max:150'],
            'dept_code'   => ['nullable', 'string', 'max:20',
                'unique:departments,code' . ($this->editingDeptId ? ",{$this->editingDeptId}" : '')],
            'dept_dir_id' => ['required', 'exists:directorates,id'],
            'dept_head_id'=> ['nullable', 'exists:users,id'],
        ]);

        $data = [
            'name'           => $this->dept_name,
            'code'           => $this->dept_code ?: null,
            'directorate_id' => $this->dept_dir_id,
            'head_user_id'   => $this->dept_head_id,
        ];

        if ($this->editingDeptId) {
            Department::findOrFail($this->editingDeptId)->update($data);
            $this->dispatch('notify', type: 'success', message: "Division updated.");
        } else {
            Department::create(array_merge($data, ['is_active' => true]));
            $this->dispatch('notify', type: 'success', message: "Division '{$this->dept_name}' created.");
        }

        $this->resetDeptForm();
    }

    public function toggleDeptStatus(int $id): void
    {
        $dept = Department::findOrFail($id);
        $dept->update(['is_active' => ! $dept->is_active]);
        $status = $dept->is_active ? 'activated' : 'deactivated';
        $this->dispatch('notify', type: 'success', message: "Division {$status}.");
    }

    public function confirmDeleteDept(int $id): void
    {
        $dept = Department::findOrFail($id);
        if ($dept->users()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: 'Cannot delete — staff are assigned to this division.');
            return;
        }
        $this->confirmType   = 'dept';
        $this->confirmId     = $id;
        $this->confirmLabel  = $dept->name;
        $this->confirmAction = 'delete';
        $this->showConfirm   = true;
    }

    public function executeConfirm(): void
    {
        if ($this->confirmType === 'dir') {
            Directorate::findOrFail($this->confirmId)->delete();
            $this->dispatch('notify', type: 'success', message: "Directorate deleted.");
        } elseif ($this->confirmType === 'dept') {
            Department::findOrFail($this->confirmId)->delete();
            $this->dispatch('notify', type: 'success', message: "Division deleted.");
        }
        $this->showConfirm = false;
    }

    private function resetDeptForm(): void
    {
        $this->showDeptForm  = false;
        $this->editingDeptId = null;
        $this->dept_name     = '';
        $this->dept_code     = '';
        $this->dept_dir_id   = null;
        $this->dept_head_id  = null;
    }

    public function render()
    {
        $directorates = Directorate::withCount('departments')
            ->with(['head', 'departments.head'])
            ->when($this->searchDir, fn($q) =>
                $q->where('name', 'ilike', '%' . $this->searchDir . '%')
            )
            ->orderBy('name')
            ->get();

        $departments = Department::with(['directorate', 'head'])
            ->when($this->searchDept, fn($q) =>
                $q->where('name', 'ilike', '%' . $this->searchDept . '%')
                  ->orWhereHas('directorate', fn($q) =>
                      $q->where('name', 'ilike', '%' . $this->searchDept . '%')
                  )
            )
            ->orderBy('name')
            ->get();

        // Directorate heads must be Secretaries (level 2)
        $dirHeads = User::active()
            ->whereHas('role', fn($q) => $q->where('hierarchy_level', 2))
            ->orderBy('first_name')->get();

        // Division heads must be Directors (level 4)
        $deptHeads = User::active()
            ->whereHas('role', fn($q) => $q->where('hierarchy_level', 4))
            ->orderBy('first_name')->get();

        $allDirectorates = Directorate::where('is_active', true)
            ->orderBy('name')->get();

        return view('livewire.admin.org-structure-manager',
            compact('directorates', 'departments', 'dirHeads', 'deptHeads', 'allDirectorates'))
            ->layout('components.layouts.app');
    }
}
