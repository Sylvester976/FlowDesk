<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Directorate;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditStaff extends Component
{
    public User $staff;

    // Personal
    public string $first_name   = '';
    public string $last_name    = '';
    public string $other_names  = '';
    public string $email        = '';
    public string $phone        = '';
    public string $id_number    = '';
    public string $pf_number    = '';
    public string $passport_number = '';
    public string $date_of_birth       = '';
    public string $date_of_appointment = '';

    // Org
    public string $role_id        = '';
    public string $directorate_id = '';
    public string $department_id  = '';
    public string $supervisor_id  = '';
    public string $attached_to_id = '';
    public string $job_title_id   = '';

    // Permissions
    public bool $is_superadmin = false;
    public bool $is_hr_admin   = false;

    // Travel
    public int $max_days_per_year = 30;

    // Status
    public string $status = 'active';

    // Cascading
    public array $departments = [];
    public array $supervisors = [];
    public array $jobTitles   = [];

    protected array $supervisorLevelMap = [
        1 => [],
        2 => [1],
        3 => [2],
        4 => [2],
        5 => [4],
        6 => [5],
        7 => [6],
        8 => [6],
        9 => [6],
    ];

    public function mount(User $user): void
    {
        $this->staff = $user;

        $this->first_name          = $user->first_name;
        $this->last_name           = $user->last_name;
        $this->other_names         = $user->other_names ?? '';
        $this->email               = $user->email;
        $this->phone               = $user->phone ?? '';
        $this->id_number           = $user->id_number ?? '';
        $this->pf_number           = $user->pf_number ?? '';
        $this->passport_number     = $user->passport_number ?? '';
        $this->date_of_birth       = $user->date_of_birth?->format('Y-m-d') ?? '';
        $this->date_of_appointment = $user->date_of_appointment?->format('Y-m-d') ?? '';
        $this->role_id             = (string) ($user->role_id ?? '');
        $this->job_title_id        = (string) ($user->job_title_id ?? '');
        $this->department_id       = (string) ($user->department_id ?? '');
        $this->supervisor_id       = (string) ($user->supervisor_id ?? '');
        $this->attached_to_id      = (string) ($user->attached_to_id ?? '');
        $this->directorate_id      = (string) ($user->department?->directorate_id ?? '');
        $this->is_superadmin       = $user->is_superadmin;
        $this->is_hr_admin         = $user->is_hr_admin;
        $this->max_days_per_year   = $user->max_days_per_year;
        $this->status              = $user->status;

        // Load cascading data
        if ($this->directorate_id) {
            $this->departments = Department::where('directorate_id', $this->directorate_id)
                ->where('is_active', true)->orderBy('name')
                ->get(['id', 'name'])->toArray();
        }
        if ($this->role_id) {
            $this->jobTitles = JobTitle::where('role_id', $this->role_id)
                ->where('is_active', true)->orderByDesc('is_default')->orderBy('name')
                ->get(['id', 'name', 'is_default'])->toArray();
            $this->loadSupervisors();
        }
    }

    protected function rules(): array
    {
        $id      = $this->staff->id;
        $minDob  = now()->subYears(60)->format('Y-m-d');
        $maxDob  = now()->subYears(18)->format('Y-m-d');

        return [
            'first_name'         => ['required', 'string', 'max:100'],
            'last_name'          => ['required', 'string', 'max:100'],
            'other_names'        => ['nullable', 'string', 'max:100'],
            'email'              => ['required', 'email', "unique:users,email,{$id}"],
            'phone'              => ['nullable', 'string', 'max:20'],
            'id_number'          => ['nullable', 'string', 'max:20', "unique:users,id_number,{$id}"],
            'pf_number'          => ['nullable', 'string', 'max:20', "unique:users,pf_number,{$id}"],
            'passport_number'    => ['nullable', 'string', 'max:20', "unique:users,passport_number,{$id}"],
            'date_of_birth'      => ['nullable', 'date', "before_or_equal:{$maxDob}", "after_or_equal:{$minDob}"],
            'date_of_appointment'=> ['nullable', 'date'],
            'role_id'            => ['required', 'exists:roles,id'],
            'job_title_id'       => ['nullable', 'exists:job_titles,id'],
            'department_id'      => ['nullable', 'exists:departments,id'],
            'supervisor_id'      => ['nullable', 'exists:users,id'],
            'attached_to_id'     => ['nullable', 'exists:users,id'],
            'max_days_per_year'  => ['required', 'integer', 'min:0', 'max:365'],
            'status'             => ['required', 'in:active,inactive,pending'],
        ];
    }

    protected $messages = [
        'date_of_birth.before_or_equal' => 'Staff must be at least 18 years old.',
        'date_of_birth.after_or_equal'  => 'Staff cannot be older than 60 years.',
        'id_number.unique'              => 'This National ID is already registered.',
        'pf_number.unique'              => 'This PF number is already registered.',
        'passport_number.unique'        => 'This passport number is already registered.',
        'email.unique'                  => 'This email address is already registered.',
    ];

    public function updatedDirectorateId(string $val): void
    {
        $this->departments   = $val
            ? Department::where('directorate_id', $val)->where('is_active', true)
                ->orderBy('name')->get(['id', 'name'])->toArray()
            : [];
        $this->department_id = '';
        $this->loadSupervisors();
    }

    public function updatedDepartmentId(): void
    {
        $this->loadSupervisors();
    }

    public function updatedRoleId(string $val): void
    {
        $this->supervisor_id = '';
        $this->job_title_id  = '';
        $this->jobTitles     = [];

        if (! $val) { $this->supervisors = []; return; }

        $role = Role::find($val);
        if (! $role) return;

        $this->jobTitles = JobTitle::where('role_id', $role->id)
            ->where('is_active', true)
            ->orderByDesc('is_default')->orderBy('name')
            ->get(['id', 'name', 'is_default'])->toArray();

        $default = collect($this->jobTitles)->firstWhere('is_default', true);
        if ($default) $this->job_title_id = (string) $default['id'];

        $this->loadSupervisors();
    }

    private function loadSupervisors(): void
    {
        $this->supervisors   = [];

        if (! $this->role_id) return;

        $role = Role::find($this->role_id);
        if (! $role) return;

        $eligibleLevels = $this->supervisorLevelMap[$role->hierarchy_level] ?? [];
        if (empty($eligibleLevels)) return;

        $this->supervisors = User::whereHas('role', fn($q) =>
                $q->whereIn('hierarchy_level', $eligibleLevels)
            )
            ->where('status', 'active')
            ->where('id', '!=', $this->staff->id)
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'pf_number', 'department_id'])
            ->map(fn($u) => [
                'id'        => $u->id,
                'name'      => $u->first_name . ' ' . $u->last_name,
                'pf_number' => $u->pf_number,
                'same_dept' => $u->department_id && $u->department_id == $this->department_id,
            ])
            ->sortByDesc('same_dept')
            ->values()
            ->toArray();
    }

    public function save(): void
    {
        $this->validate();

        $this->staff->update([
            'first_name'          => $this->first_name,
            'last_name'           => $this->last_name,
            'other_names'         => $this->other_names ?: null,
            'email'               => $this->email,
            'phone'               => $this->phone ?: null,
            'id_number'           => $this->id_number ?: null,
            'pf_number'           => $this->pf_number ?: null,
            'passport_number'     => $this->passport_number ?: null,
            'date_of_birth'       => $this->date_of_birth ?: null,
            'date_of_appointment' => $this->date_of_appointment ?: null,
            'role_id'             => $this->role_id,
            'job_title_id'        => $this->job_title_id ?: null,
            'department_id'       => $this->department_id ?: null,
            'supervisor_id'       => $this->supervisor_id ?: null,
            'attached_to_id'      => $this->attached_to_id ?: null,
            'is_superadmin'       => $this->is_superadmin,
            'is_hr_admin'         => $this->is_hr_admin,
            'max_days_per_year'   => $this->max_days_per_year,
            'status'              => $this->status,
        ]);

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', "{$this->staff->full_name} updated successfully.");

        $this->redirect(route('admin.staff.index'), navigate: false);
    }

    public function render()
    {
        $roles        = Role::orderBy('hierarchy_level')->get();
        $directorates = Directorate::where('is_active', true)->orderBy('name')->get();
        $allStaff     = User::active()->where('id', '!=', $this->staff->id)
            ->orderBy('first_name')->get(['id', 'first_name', 'last_name', 'role_id']);

        return view('livewire.admin.edit-staff',
            compact('roles', 'directorates', 'allStaff'))
            ->layout('components.layouts.app');
    }
}
