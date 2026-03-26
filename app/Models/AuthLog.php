<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthLog extends Model
{
    use MassPrunable;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email_attempted',
        'event',
        'ip_address',
        'user_agent',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ── Pruning — keep 1 year of auth logs ───────────────────
    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subYear());
    }

    // ── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
