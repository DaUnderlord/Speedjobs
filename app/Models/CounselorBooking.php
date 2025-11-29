<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounselorBooking extends Model
{
    protected $fillable = [
        'user_id',
        'counselor_id',
        'payment_id',
        'session_date',
        'session_time',
        'duration_minutes',
        'session_type',
        'meeting_link',
        'status',
        'notes',
        'feedback_rating',
        'feedback_comment',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function counselor(): BelongsTo
    {
        return $this->belongsTo(Counselor::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed'])
            ->where('session_date', '>=', now()->toDateString());
    }

    public function confirm()
    {
        $this->update(['status' => 'confirmed']);
    }

    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
