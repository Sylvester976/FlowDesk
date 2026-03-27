<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncLog extends Model
{
    protected $fillable = [
        'sync_type', 'direction', 'started_at', 'completed_at',
        'total_records', 'synced_count', 'skipped_count',
        'conflict_count', 'error_count', 'conflicts', 'errors',
        'triggered_by',
    ];

    protected $casts = [
        'started_at'    => 'datetime',
        'completed_at'  => 'datetime',
        'conflicts'     => 'array',
        'errors'        => 'array',
    ];

    public function triggeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }

    public function getDurationAttribute(): ?string
    {
        if (! $this->completed_at) return null;
        $seconds = $this->started_at->diffInSeconds($this->completed_at);
        return $seconds < 60 ? "{$seconds}s" : round($seconds / 60, 1) . 'm';
    }
}
