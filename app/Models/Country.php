<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso2',
        'iso3',
        'dial_code',
        'currency_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function travelApplications(): HasMany
    {
        return $this->hasMany(TravelApplication::class);
    }

    public function travelRates(): HasMany
    {
        return $this->hasMany(TravelRate::class);
    }
}
