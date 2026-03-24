<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Directorate;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateStaff extends Component
{
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

    // Cascading data
    public array $departments  = [];
    public array $supervisors  = [];
    public array $jobTitles    = [];

    // Supervisor level map — who can supervise each level
    protected array $supervisorLevelMap = [
        1 => [],      // PS — no supervisor
        2 => [1],     // Secretary → PS
        3 => [2],     // Asst Secretary → Secretary
        4 => [2],     // Director → Secretary (skips Asst Sec)
        5 => [4],     // Deputy Director → Director
        6 => [5],     // Assistant Director → DD
        7 => [6],     // Principal Officer → AD
        8 => [6],     // Senior Officer → AD
        9 => [6],     // Officer → AD
    ];

    protected function rules(): array
    {
        $minDob = now()->subYears(60)->format('Y-m-d');
        $maxDob = now()->subYears(18)->format('Y-m-d');

        return [
            'first_name'         => ['required', 'string', 'max:100'],
            'last_name'          => ['required', 'string', 'max:100'],
            'other_names'        => ['nullable', 'string', 'max:100'],
            'email'              => ['required', 'email', 'unique:users,email'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'id_number'          => ['nullable', 'string', 'max:20', 'unique:users,id_number'],
            'pf_number'          => ['nullable', 'string', 'max:20', 'unique:users,pf_number'],
            'passport_number'    => ['nullable', 'string', 'max:20', 'unique:users,passport_number'],
            'date_of_birth'      => ['nullable', 'date', "before_or_equal:{$maxDob}", "after_or_equal:{$minDob}"],
            'date_of_appointment'=> ['nullable', 'date'],
            'role_id'            => ['required', 'exists:roles,id'],
            'job_title_id'       => ['nullable', 'exists:job_titles,id'],
            'department_id'      => ['nullable', 'exists:departments,id'],
            'supervisor_id'      => ['nullable', 'exists:users,id'],
            'attached_to_id'     => ['nullable', 'exists:users,id'],
            'max_days_per_year'  => ['required', 'integer', 'min:0', 'max:365'],
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
            ? Department::where('directorate_id', $val)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name'])
                ->toArray()
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
        if (! $role) { $this->supervisors = []; return; }

        // Load job titles for this role
        $this->jobTitles = JobTitle::where('role_id', $role->id)
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get(['id', 'name', 'is_default'])
            ->toArray();

        // Pre-select default
        $default = collect($this->jobTitles)->firstWhere('is_default', true);
        if ($default) $this->job_title_id = (string) $default['id'];

        $this->loadSupervisors();
    }

    private function loadSupervisors(): void
    {
        $this->supervisors   = [];
        $this->supervisor_id = '';

        if (! $this->role_id) return;

        $role = Role::find($this->role_id);
        if (! $role) return;

        $level          = $role->hierarchy_level;
        $eligibleLevels = $this->supervisorLevelMap[$level] ?? [];

        if (empty($eligibleLevels)) return; // PS — no supervisor

        $query = User::whereHas('role', fn($q) =>
                $q->whereIn('hierarchy_level', $eligibleLevels)
            )
            ->where('status', 'active')
            ->orderBy('first_name');

        // If a division is selected, prefer supervisors in the same division
        // but always show all eligible users so the option is there
        $this->supervisors = $query
            ->get(['id', 'first_name', 'last_name', 'pf_number', 'department_id'])
            ->map(function ($u) {
                return [
                    'id'         => $u->id,
                    'name'       => $u->first_name . ' ' . $u->last_name,
                    'pf_number'  => $u->pf_number,
                    'same_dept'  => $u->department_id && $u->department_id == $this->department_id,
                ];
            })
            // Sort: same division first
            ->sortByDesc('same_dept')
            ->values()
            ->toArray();
    }

    public function save(): void
    {
        $this->validate();

        $password = Str::random(10) . rand(10, 99) . '!';

        $user = User::create([
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'other_names'           => $this->other_names ?: null,
            'email'                 => $this->email,
            'phone'                 => $this->phone ?: null,
            'password'              => Hash::make($password),
            'id_number'             => $this->id_number ?: null,
            'pf_number'             => $this->pf_number ?: null,
            'passport_number'       => $this->passport_number ?: null,
            'date_of_birth'         => $this->date_of_birth ?: null,
            'date_of_appointment'   => $this->date_of_appointment ?: null,
            'role_id'               => $this->role_id,
            'job_title_id'          => $this->job_title_id ?: null,
            'department_id'         => $this->department_id ?: null,
            'supervisor_id'         => $this->supervisor_id ?: null,
            'attached_to_id'        => $this->attached_to_id ?: null,
            'is_superadmin'         => $this->is_superadmin,
            'is_hr_admin'           => $this->is_hr_admin,
            'max_days_per_year'     => $this->max_days_per_year,
            'days_used_this_year'   => 0,
            'docket_year'           => now()->year,
            'status'                => 'active',
            'force_password_change' => true,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::html(
                view('emails.welcome-staff', [
                    'user'     => $user,
                    'password' => $password,
                    'loginUrl' => url('/login'),
                ])->render(),
                fn($m) => $m->to($user->email)
                    ->subject('Your FlowDesk Account — Login Details')
            );
        } catch (\Exception $e) {
            \Log::error('Welcome email failed: ' . $e->getMessage());
        }

        session()->flash('notify_type', 'success');
        session()->flash('notify_message', "{$user->full_name} created. Login details sent by email.");

        $this->redirect(route('admin.staff.index'), navigate: false);
    }

    public function render()
    {
        $roles        = Role::where('is_ps', false)
            ->orderBy('hierarchy_level')
            ->get();

        $directorates = Directorate::where('is_active', true)
            ->orderBy('name')
            ->get();

        // All active staff for "attached to" field
        $allStaff = User::active()
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'role_id']);

        return view('livewire.admin.create-staff',
            compact('roles', 'directorates', 'allStaff'))
            ->layout('components.layouts.app');
    }
}
