<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'other_names',
        'email',
        'phone',
        'password',
        'pf_number',
        'id_number',
        'passport_number',
        'diplomatic_passport_number',
        'date_of_birth',
        'date_of_appointment',
        'role_id',
        'job_title_id',
        'department_id',
        'supervisor_id',
        'attached_to_id',
        'is_superadmin',
        'is_hr_admin',
        'max_days_per_year',
        'days_used_this_year',
        'docket_year',
        'status',
        'force_password_change',
        'profile_photo',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'last_login_at'         => 'datetime',
        'date_of_birth'         => 'date',
        'date_of_appointment'   => 'date',
        'max_days_per_year'     => 'integer',
        'days_used_this_year'   => 'integer',
        'docket_year'           => 'integer',
        'is_superadmin'         => 'boolean',
        'is_hr_admin'           => 'boolean',
        'force_password_change' => 'boolean',
        'password'              => 'hashed',
    ];

    // =========================================================
    // Relationships
    // =========================================================

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function attachedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attached_to_id');
    }

    public function attachedStaff(): HasMany
    {
        return $this->hasMany(User::class, 'attached_to_id');
    }

    public function otps(): HasMany
    {
        return $this->hasMany(Otp::class);
    }

    public function travelApplications(): HasMany
    {
        return $this->hasMany(TravelApplication::class);
    }

    public function concurrenceSteps(): HasMany
    {
        return $this->hasMany(ConcurrenceStep::class, 'approver_id');
    }

    public function supervisorFeedback(): HasMany
    {
        return $this->hasMany(SupervisorFeedback::class, 'supervisor_id');
    }

    // =========================================================
    // Permission helpers
    // =========================================================

    /** ICT superadmin (is_superadmin flag) OR the PS role */
    public function isSuperAdmin(): bool
    {
        return $this->is_superadmin === true || $this->role?->is_ps === true;
    }

    /** Specifically the Principal Secretary role */
    public function isPS(): bool
    {
        return $this->role?->is_ps === true;
    }

    /** HR admin flag — independent of role hierarchy */
    public function isHR(): bool
    {
        return $this->is_hr_admin === true;
    }

    /**
     * A user is a supervisor if their role allows supervising
     * AND they actually have active subordinates.
     */
    public function isSupervisor(): bool
    {
        return $this->role?->can_supervise === true
            && $this->subordinates()->where('status', 'active')->exists();
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin() || $this->isHR();
    }

    public function canAssignRoles(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canConcur(): bool
    {
        return $this->isSuperAdmin() || $this->isPS() || $this->isSupervisor();
    }

    public function canViewAllApplications(): bool
    {
        return $this->isSuperAdmin() || $this->isPS() || $this->isHR();
    }

    public function canViewOutOfOffice(): bool
    {
        return $this->isSuperAdmin() || $this->isPS() || $this->isHR();
    }

    /** Returns the numeric hierarchy level (1 = PS, 9 = Officer) */
    public function hierarchyLevel(): int
    {
        return $this->role?->hierarchy_level ?? 99;
    }

    // =========================================================
    // Notification logic
    // =========================================================

    /**
     * Who concurs this user's foreign official travel — always direct supervisor.
     */
    public function getConcurrer(): ?self
    {
        return $this->supervisor;
    }

    /**
     * Who gets notified when this user submits a travel application.
     */
    public function getNotifyList(): \Illuminate\Support\Collection
    {
        $level = $this->hierarchyLevel();

        // PS — nobody above
        if ($level === 1) {
            return collect();
        }

        // Secretary (2) — notify PS
        if ($level === 2) {
            return User::whereHas('role', fn($q) => $q->where('is_ps', true))
                ->where('status', 'active')
                ->get();
        }

        // Director (4), Assistant Secretary (3) — notify Secretary of directorate
        if (in_array($level, [3, 4])) {
            return $this->getPeopleInDirectorateAtLevels([2]);
        }

        // Deputy Director (5) — notify Director in same division
        if ($level === 5) {
            return $this->getPeopleInDepartmentAtLevels([4]);
        }

        // Assistant Director (6) — notify DD + Director in same division
        if ($level === 6) {
            return $this->getPeopleInDepartmentAtLevels([4, 5]);
        }

        // Principal / Senior / Officer (7-9) — notify AD + DD + Director
        if ($level >= 7) {
            return $this->getPeopleInDepartmentAtLevels([4, 5, 6]);
        }

        return collect();
    }

    private function getPeopleInDepartmentAtLevels(array $levels): \Illuminate\Support\Collection
    {
        if (! $this->department_id) return collect();

        return User::where('department_id', $this->department_id)
            ->where('id', '!=', $this->id)
            ->where('status', 'active')
            ->whereHas('role', fn($q) => $q->whereIn('hierarchy_level', $levels))
            ->get();
    }

    private function getPeopleInDirectorateAtLevels(array $levels): \Illuminate\Support\Collection
    {
        $directorateId = $this->department?->directorate_id;
        if (! $directorateId) return collect();

        return User::whereHas('department', fn($q) =>
                $q->where('directorate_id', $directorateId)
            )
            ->where('id', '!=', $this->id)
            ->where('status', 'active')
            ->whereHas('role', fn($q) => $q->whereIn('hierarchy_level', $levels))
            ->get();
    }

    // =========================================================
    // Computed attributes
    // =========================================================

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDisplayTitleAttribute(): string
    {
        return $this->jobTitle?->name ?? $this->role?->label ?? '';
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->docket_year !== now()->year) {
            return $this->max_days_per_year;
        }
        return max(0, $this->max_days_per_year - $this->days_used_this_year);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasPendingPostTripUploads(): bool
    {
        return $this->travelApplications()
            ->where('status', 'pending_uploads')
            ->exists();
    }

    // =========================================================
    // Query scopes
    // =========================================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAtLevels($query, array $levels)
    {
        return $query->whereHas('role', fn($q) =>
            $q->whereIn('hierarchy_level', $levels)
        );
    }

    public function scopeInDepartment($query, int $deptId)
    {
        return $query->where('department_id', $deptId);
    }
}
