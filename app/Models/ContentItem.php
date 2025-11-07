<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContentItem extends Model
{
    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'category_id',
        'date',
        'objective_list',
        'image',
        'status',
        'order',
        'price',
        'currency',
        'duration_days',
        'max_students',
        'start_date',
        'end_date',
        'is_enrollable',
    ];

    protected $casts = [
        'date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'objective_list' => 'array',
        'price' => 'decimal:2',
        'is_enrollable' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });

        static::updating(function ($item) {
            if ($item->isDirty('title') && empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all enrollments for this training.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'training_id');
    }

    /**
     * Check if training is enrollable.
     */
    public function isEnrollable(): bool
    {
        return $this->is_enrollable && 
               $this->type === 'training' &&
               $this->status === 'active';
    }

    /**
     * Check if training has available spots.
     */
    public function hasAvailableSpots(): bool
    {
        if (!$this->max_students) {
            return true; // No limit
        }
        
        $currentEnrollments = $this->enrollments()
            ->where('status', 'paid')
            ->count();
            
        return $currentEnrollments < $this->max_students;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default.png');
    }
}
