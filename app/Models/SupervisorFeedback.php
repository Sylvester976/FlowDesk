<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisorFeedback extends Model
{
    protected $fillable = [
        'application_id',
        'supervisor_id',
        'stance',
        'comments',
    ];

    public static array $stanceLabels = [
        'agrees'       => 'Agrees with travel',
        'disagrees'    => 'Disagrees with travel',
        'no_objection' => 'No objection',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'application_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function getStanceLabelAttribute(): string
    {
        return self::$stanceLabels[$this->stance] ?? $this->stance;
    }
}
