<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationLog extends Model
{
    // Immutable — no updates ever
    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'actor_id',
        'actor_label',
        'event',
        'from_status',
        'to_status',
        'payload',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'payload'    => 'array',
        'created_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'application_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // Static helper — call this everywhere instead of creating manually
    public static function record(
        int $applicationId,
        string $event,
        ?int $actorId = null,
        ?string $actorLabel = null,
        ?string $fromStatus = null,
        ?string $toStatus = null,
        array $payload = [],
        ?string $ip = null,
    ): self {
        return static::create([
            'application_id' => $applicationId,
            'actor_id'       => $actorId,
            'actor_label'    => $actorLabel,
            'event'          => $event,
            'from_status'    => $fromStatus,
            'to_status'      => $toStatus,
            'payload'        => $payload ?: null,
            'ip_address'     => $ip ?? request()?->ip(),
            'user_agent'     => request()?->userAgent(),
            'created_at'     => now(),
        ]);
    }
}
