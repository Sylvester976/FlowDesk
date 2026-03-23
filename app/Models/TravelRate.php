<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelRate extends Model
{
    protected $fillable = [
        'country_id',
        'role_id',
        'daily_subsistence_usd',
        'accommodation_usd',
        'currency_code',
        'effective_from',
        'effective_to',
        'notes',
    ];

    protected $casts = [
        'daily_subsistence_usd' => 'decimal:2',
        'accommodation_usd'     => 'decimal:2',
        'effective_from'        => 'date',
        'effective_to'          => 'date',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isActive(): bool
    {
        $today = now()->toDateString();

        return $this->effective_from <= $today
            && ($this->effective_to === null || $this->effective_to >= $today);
    }
}
