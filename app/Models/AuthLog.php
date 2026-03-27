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

    // ── Pruning — keep 1 year ─────────────────────────────────
    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subYear());
    }

    // ── Relationships ─────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Static helper ─────────────────────────────────────────
    /**
     * Convenience method used throughout the auth flow.
     *
     * Usage:
     *   AuthLog::record('login_success', $user->id, $user->email);
     *   AuthLog::record('login_failed', null, $emailAttempted, 'reason here');
     *   AuthLog::record('lockout', null, $email, 'Too many attempts');
     */
    public static function record(
        string  $event,
        ?int    $userId,
        ?string $emailAttempted = null,
        ?string $notes = null
    ): static {
        return static::create([
            'user_id'         => $userId,
            'email_attempted' => $emailAttempted,
            'event'           => $event,
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
            'notes'           => $notes,
            'created_at'      => now(),
        ]);
    }
}
