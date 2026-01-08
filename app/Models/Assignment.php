<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'my_assignments';

    protected $fillable = [
        'user_id',
        'assignment_name',   // now used as justification_of_travel
        'travel_type',       // OFFICIAL | PERSONAL
        'name',
        'country_of_visit',
        'county',
        'subcounty',
        'location',
        'city',
        'supervisor_name',
        'supervisor_email',
        'status',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(AssignmentAttachment::class);
    }
}

