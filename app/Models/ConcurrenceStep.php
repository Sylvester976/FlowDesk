<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcurrenceStep extends Model
{
    protected $fillable = [
        'application_id',
        'approver_id',
        'decision',
        'comments',
        'is_system',
        'system_reason',
        'decided_at',
        'decided_ip',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
        'is_system'  => 'boolean',
    ];

    public static array $decisionLabels = [
        'concurred'      => 'Concurred',
        'not_concurred'  => 'Not Concurred',
        'returned'       => 'Returned for Correction',
        'auto_concurred' => 'Auto-Concurred (System)',
        'pending'        => 'Pending',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'application_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function getDecisionLabelAttribute(): string
    {
        return self::$decisionLabels[$this->decision] ?? $this->decision;
    }

    public function isPending(): bool
    {
        return $this->decision === 'pending';
    }

    public function isConcurred(): bool
    {
        return in_array($this->decision, ['concurred', 'auto_concurred']);
    }
}
