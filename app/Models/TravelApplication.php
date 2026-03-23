<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_number',
        'user_id',
        'travel_type',
        'country_id',
        'county_id',
        'city',
        'county',
        'subcounty',
        'purpose_type',
        'justification',
        'start_date',
        'end_date',
        'days_requested',
        'delegation_size',
        'sponsor',
        'total_cost_usd',
        'status',
        'auto_approved_at',
        'days_used_before',
        'days_used_after',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'end_date'         => 'date',
        'auto_approved_at' => 'datetime',
        'days_requested'   => 'integer',
        'delegation_size'  => 'integer',
        'total_cost_usd'   => 'decimal:2',
        'days_used_before' => 'integer',
        'days_used_after'  => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }

    public function concurrenceSteps(): HasMany
    {
        return $this->hasMany(ConcurrenceStep::class, 'application_id');
    }

    public function supervisorFeedback(): HasMany
    {
        return $this->hasMany(SupervisorFeedback::class, 'application_id');
    }

    public function postTripUpload(): HasOne
    {
        return $this->hasOne(PostTripUpload::class, 'application_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApplicationLog::class, 'application_id')
            ->orderBy('created_at', 'asc');
    }

    // -------------------------------------------------------------------------
    // Status helpers
    // -------------------------------------------------------------------------

    public function isForeignOfficial(): bool
    {
        return $this->travel_type === 'foreign_official';
    }

    public function isForeignPrivate(): bool
    {
        return $this->travel_type === 'foreign_private';
    }

    public function isLocal(): bool
    {
        return $this->travel_type === 'local';
    }

    public function isPendingConcurrence(): bool
    {
        return $this->status === 'pending_concurrence';
    }

    public function isConcurred(): bool
    {
        return $this->status === 'concurred';
    }

    public function isApproved(): bool
    {
        return in_array($this->status, ['concurred', 'approved']);
    }

    public function isPendingUploads(): bool
    {
        return $this->status === 'pending_uploads';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function requiresConcurrence(): bool
    {
        return $this->travel_type === 'foreign_official';
    }

    // -------------------------------------------------------------------------
    // Reference number generator
    // -------------------------------------------------------------------------

    public static function generateReference(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;

        return sprintf('TRV-%s-%05d', $year, $count);
    }

    // -------------------------------------------------------------------------
    // Required documents per travel type
    // -------------------------------------------------------------------------

    public static function requiredDocuments(string $travelType): array
    {
        return match ($travelType) {
            'foreign_official' => [
                'invitation_letter',
                'program',
                'accountant_letter',
                'procurement_letter',
            ],
            'foreign_private' => [
                'leave_approval',
            ],
            'local' => [
                'assignment_brief',
            ],
            default => [],
        };
    }
}
