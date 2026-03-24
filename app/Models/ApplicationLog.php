<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationLog extends Model
{
    protected $fillable = [
        'travel_application_id',
        'user_id',
        'action',
        'description',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'travel_application_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
