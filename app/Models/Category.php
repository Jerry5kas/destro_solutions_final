<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title') && empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    public function contentItems()
    {
        return $this->hasMany(ContentItem::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default.png');
    }

    /**
     * Get categories that have content items of a specific type.
     *
     * @param string $contentType
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByContentType(string $contentType)
    {
        return static::whereHas('contentItems', function ($query) use ($contentType) {
            $query->where('type', $contentType)
                  ->where('status', 'active');
        })
        ->where('is_active', true)
        ->orderBy('order')
        ->orderBy('title')
        ->get();
    }
}
