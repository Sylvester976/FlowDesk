<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcurrenceStep extends Model
{
    protected $fillable = [
        'travel_application_id',
        'approver_id',
        'action',
        'comments',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'travel_application_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function isPending(): bool
    {
        return $this->action === 'pending';
    }
}
