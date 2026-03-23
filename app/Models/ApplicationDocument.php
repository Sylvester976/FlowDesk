<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'application_id',
        'uploaded_by',
        'doc_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public static array $docTypeLabels = [
        'invitation_letter'  => 'Invitation Letter',
        'program'            => 'Program / Agenda',
        'accountant_letter'  => 'Accountant Letter',
        'procurement_letter' => 'Procurement Letter',
        'delegate_list'      => 'Delegate List',
        'leave_approval'     => 'Leave Approval',
        'assignment_brief'   => 'Assignment Brief',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(TravelApplication::class, 'application_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getLabelAttribute(): string
    {
        return self::$docTypeLabels[$this->doc_type] ?? ucfirst($this->doc_type);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $size = $this->file_size ?? 0;

        if ($size < 1024) return $size . ' B';
        if ($size < 1048576) return round($size / 1024, 1) . ' KB';

        return round($size / 1048576, 1) . ' MB';
    }
}
