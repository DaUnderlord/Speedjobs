<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CounselingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_type',
        'message',
        'preferred_date',
        'preferred_time',
        'status',
        'assigned_counselor_id',
        'admin_notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedCounselor(): BelongsTo
    {
        return $this->belongsTo(Counselor::class, 'assigned_counselor_id');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(CounselorBooking::class);
    }
}
