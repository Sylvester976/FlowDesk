<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTripUpload extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'uploaded_by',
        'ticket_path',
        'passport_path',
        'report_path',
        'accommodation_cost',
        'ticket_cost',
        'participation_fee',
        'achievements',
        'submitted_at',
    ];

    protected $casts = [
        'accommodation_cost' => 'decimal:2',
        'ticket_cost'        => 'decimal:2',
        'participation_fee'  => 'decimal:2',
        'submitted_at'       => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'application_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getTotalCostAttribute(): float
    {
        return (float) $this->accommodation_cost
            + (float) $this->ticket_cost
            + (float) $this->participation_fee;
    }

    public function isComplete(): bool
    {
        return $this->report_path && $this->submitted_at;
    }
}
