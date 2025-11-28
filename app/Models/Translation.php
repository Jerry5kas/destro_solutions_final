<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    protected $fillable = [
        'locale',
        'field',
        'value',
        'is_auto',
        'locked',
        'translated_at',
        'translatable_type',
        'translatable_id',
    ];

    protected $casts = [
        'is_auto' => 'boolean',
        'locked' => 'boolean',
        'translated_at' => 'datetime',
    ];

    /**
     * Get the parent translatable model.
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to get translations for a specific locale.
     */
    public function scopeForLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Scope to get translations for a specific field.
     */
    public function scopeForField($query, string $field)
    {
        return $query->where('field', $field);
    }

    /**
     * Find or create a translation entry.
     */
    public static function findOrCreate(
        string $locale,
        string $field,
        string $translatableType,
        int $translatableId,
        ?string $value = null
    ): self {
        return self::firstOrCreate(
            [
                'locale' => $locale,
                'field' => $field,
                'translatable_type' => $translatableType,
                'translatable_id' => $translatableId,
            ],
            [
                'value' => $value,
            ]
        );
    }
}

