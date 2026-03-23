<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthLog extends Model
{
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(
        string $event,
        ?int $userId = null,
        ?string $emailAttempted = null,
        ?string $notes = null,
    ): self {
        return static::create([
            'user_id'          => $userId,
            'email_attempted'  => $emailAttempted,
            'event'            => $event,
            'ip_address'       => request()?->ip(),
            'user_agent'       => request()?->userAgent(),
            'notes'            => $notes,
            'created_at'       => now(),
        ]);
    }
}
