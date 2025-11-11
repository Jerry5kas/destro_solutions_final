<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSection extends Model
{
    protected $fillable = [
        'type',
        'image_path',
        'video_path',
        'title',
        'description',
    ];

    protected $appends = [
        'image_url',
        'video_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        return Storage::disk('public')->exists($this->image_path)
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function getVideoUrlAttribute(): ?string
    {
        if (!$this->video_path) {
            return null;
        }

        if (Str::startsWith($this->video_path, ['http://', 'https://'])) {
            return $this->video_path;
        }

        return Storage::disk('public')->exists($this->video_path)
            ? asset('storage/' . $this->video_path)
            : null;
    }
}

