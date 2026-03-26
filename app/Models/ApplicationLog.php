<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationLog extends Model
{
    use MassPrunable;

    public $timestamps = false;

    protected $fillable = [
        'travel_application_id',
        'user_id',
        'action',
        'description',
        'metadata',
        'created_at',
    ];

    protected $casts = [
        'metadata'   => 'array',
        'created_at' => 'datetime',
    ];

    // ── Pruning — keep 2 years of application logs ────────────
    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subYears(2));
    }

    // ── Relationships ─────────────────────────────────────────

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'travel_application_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
