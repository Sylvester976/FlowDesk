<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'travel_application_id',
        'document_type',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'travel_application_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getTypeLabel(): string
    {
        return match($this->document_type) {
            'invitation_letter'   => 'Invitation / Request Letter',
            'appointment_letter'  => 'Appointment Letter',
            'passport_copy'       => 'Passport Copy',
            'leave_form'          => 'Leave Form',
            'post_trip_report'    => 'Post-Trip Report',
            'post_trip_ticket'    => 'Travel Ticket',
            'post_trip_passport'  => 'Passport (Stamped)',
            'other'               => 'Other Document',
            default               => ucfirst(str_replace('_', ' ', $this->document_type)),
        };
    }
}
