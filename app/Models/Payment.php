<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'counselor_booking_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_reference',
        'status',
        'payment_gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_gateway_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function counselorBooking(): BelongsTo
    {
        return $this->belongsTo(CounselorBooking::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function markAsCompleted($gatewayResponse = null)
    {
        $this->update([
            'status' => 'completed',
            'payment_gateway_response' => $gatewayResponse,
        ]);
    }

    public function markAsFailed($gatewayResponse = null)
    {
        $this->update([
            'status' => 'failed',
            'payment_gateway_response' => $gatewayResponse,
        ]);
    }
}
