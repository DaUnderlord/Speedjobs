<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'long_description',
        'instructor_name',
        'instructor_bio',
        'instructor_image',
        'thumbnail_image',
        'level',
        'duration_hours',
        'price',
        'is_free',
        'is_published',
        'enrollment_count',
        'rating',
        'total_reviews',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_free' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(CourseLesson::class)->orderBy('order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }

    public function isEnrolledBy($userId): bool
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }
}
