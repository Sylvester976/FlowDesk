<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'label',
        'hierarchy_level',
        'can_supervise',
        'is_ps',
        'is_system',
    ];

    protected $casts = [
        'can_supervise'   => 'boolean',
        'is_ps'           => 'boolean',
        'is_system'       => 'boolean',
        'hierarchy_level' => 'integer',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function jobTitles(): HasMany
    {
        return $this->hasMany(JobTitle::class);
    }

    public function travelRates(): HasMany
    {
        return $this->hasMany(TravelRate::class);
    }

    /**
     * Roles that can be supervisors for a given level.
     * Supervisor must have a lower hierarchy number (= higher in org).
     */
    public static function eligibleSupervisors(int $forLevel): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('hierarchy_level', '<', $forLevel)
            ->where('can_supervise', true)
            ->orderBy('hierarchy_level')
            ->get();
    }
}
