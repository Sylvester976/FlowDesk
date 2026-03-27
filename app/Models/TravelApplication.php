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
        'user_id',
        'travel_type',
        'country_id',
        'county_id',
        'destination_details',
        'departure_date',
        'return_date',
        'per_diem_days',
        'funding_source',
        'purpose',
        'leave_approved',
        'status',
        'reference_number',
        'clearance_letter_path',
        'clearance_letter_generated_at',
    ];

    protected $casts = [
        'departure_date'               => 'date',
        'return_date'                  => 'date',
        'leave_approved'               => 'boolean',
        'clearance_letter_generated_at'=> 'datetime',
        'per_diem_days'               => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────

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
        return $this->hasMany(ApplicationDocument::class);
    }

    public function concurrenceSteps(): HasMany
    {
        return $this->hasMany(ConcurrenceStep::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function postTripUpload(): HasOne
    {
        return $this->hasOne(PostTripUpload::class);
    }

    // ── Helpers ───────────────────────────────────────────────

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

    public function isForeign(): bool
    {
        return in_array($this->travel_type, ['foreign_official', 'foreign_private']);
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['submitted', 'pending_concurrence']);
    }

    public function isActionable(): bool
    {
        return $this->status === 'pending_concurrence';
    }

    public function getTravelTypeLabel(): string
    {
        return match($this->travel_type) {
            'foreign_official' => 'Foreign Official',
            'foreign_private'  => 'Foreign Private',
            'local'            => 'Local',
            default            => 'Unknown',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'draft'               => 'Draft',
            'submitted'           => 'Submitted',
            'pending_concurrence' => 'Awaiting Concurrence',
            'concurred'           => 'Concurred',
            'not_concurred'       => 'Not Concurred',
            'returned'            => 'Returned',
            'cancelled'           => 'Cancelled',
            'pending_uploads'     => 'Post-trip Pending',
            'closed'              => 'Closed',
            default               => ucfirst($this->status),
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'draft'               => 'secondary',
            'submitted'           => 'info',
            'pending_concurrence' => 'warning',
            'concurred'           => 'success',
            'not_concurred'       => 'danger',
            'returned'            => 'warning',
            'cancelled'           => 'secondary',
            'pending_uploads'     => 'warning',
            'closed'              => 'success',
            default               => 'secondary',
        };
    }

    public function getDurationDays(): int
    {
        return $this->departure_date->diffInDays($this->return_date) + 1;
    }

    // ── Audit log helper ──────────────────────────────────────

    public function log(string $action, string $description, ?array $meta = null): void
    {
        $this->logs()->create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'meta'        => $meta,
            'created_at'  => now(),
        ]);
    }

    // ── Reference number generator ────────────────────────────

    public static function generateReference(string $type): string
    {
        $prefix = match($type) {
            'foreign_official' => 'FO',
            'foreign_private'  => 'FP',
            'local'            => 'LC',
            default            => 'TR',
        };

        $year  = now()->format('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;

        return "{$prefix}-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
