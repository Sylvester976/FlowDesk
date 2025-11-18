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
        'country_of_visit',
        'county',
        'subcounty',
        'location',
        'city',
        'supervisor_name',
        'supervisor_email',
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

