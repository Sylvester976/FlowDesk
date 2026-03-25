<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelRate extends Model
{
    protected $fillable = [
        'category',
        'destination',
        'rate_type',
        'amount',
        'currency',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount'    => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getTypeLabel(): string
    {
        return match($this->rate_type) {
            'per_diem'      => 'Per Diem',
            'accommodation' => 'Accommodation',
            'transport'     => 'Transport',
            'incidental'    => 'Incidental',
            default         => ucfirst($this->rate_type),
        };
    }
}
