<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostTripUpload extends Model
{
    protected $fillable = [
        'travel_application_id',
        'user_id',
        'report_summary',
        'actual_cost',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'actual_cost'  => 'decimal:2',
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
