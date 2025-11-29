<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Counselor extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'bio',
        'years_of_experience',
        'hourly_rate',
        'profile_image',
        'is_available',
        'rating',
        'total_sessions',
        'certifications',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_available' => 'boolean',
        'certifications' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(CounselorAvailability::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(CounselorBooking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeBySpecialization($query, $specialization)
    {
        return $query->where('specialization', $specialization);
    }
}
