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
        'department_id',
        'supervisor_id',
        'max_days_per_year',
        'days_used_this_year',
        'docket_year',
        'status',
        'profile_photo',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'    => 'datetime',
        'last_login_at'        => 'datetime',
        'date_of_birth'        => 'date',
        'date_of_appointment'  => 'date',
        'max_days_per_year'    => 'integer',
        'days_used_this_year'  => 'integer',
        'docket_year'          => 'integer',
        'password'             => 'hashed',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
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

    // -------------------------------------------------------------------------
    // Role helper methods — use these everywhere instead of checking role_id
    // -------------------------------------------------------------------------

    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'superadmin';
    }

    public function isPS(): bool
    {
        return $this->role?->is_ps === true;
    }

    public function isHR(): bool
    {
        return $this->role?->name === 'hr';
    }

    public function isSupervisor(): bool
    {
        return $this->subordinates()->exists();
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
        return $this->isSuperAdmin() || $this->isPS();
    }

    public function canViewOutOfOffice(): bool
    {
        return $this->isSuperAdmin() || $this->isPS() || $this->isHR();
    }

    // -------------------------------------------------------------------------
    // Computed attributes
    // -------------------------------------------------------------------------

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDaysRemainingAttribute(): int
    {
        // Reset docket if it's a new year
        if ($this->docket_year !== now()->year) {
            return $this->max_days_per_year;
        }

        return max(0, $this->max_days_per_year - $this->days_used_this_year);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // -------------------------------------------------------------------------
    // Post-trip gate — blocks new applications if prior trip has no uploads
    // -------------------------------------------------------------------------

    public function hasPendingPostTripUploads(): bool
    {
        return $this->travelApplications()
            ->where('status', 'pending_uploads')
            ->exists();
    }
}
