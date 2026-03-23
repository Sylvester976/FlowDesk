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

    public function travelRates(): HasMany
    {
        return $this->hasMany(TravelRate::class);
    }
}
