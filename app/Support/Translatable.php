<?php

namespace App\Support;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Translatable
{
    /**
     * Get all translations for this model.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Get translation for a specific field in current locale.
     */
    public function translate(string $field, ?string $locale = null, ?string $fallback = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = $fallback ?? config('app.fallback_locale', 'en');

        // Try to get translation for current locale
        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('field', $field)
            ->first();

        if ($translation && $translation->value) {
            return $translation->value;
        }

        // Fallback to default locale
        if ($locale !== $fallback) {
            $translation = $this->translations()
                ->where('locale', $fallback)
                ->where('field', $field)
                ->first();

            if ($translation && $translation->value) {
                return $translation->value;
            }
        }

        // Fallback to original attribute
        return $this->attributes[$field] ?? null;
    }

    /**
     * Set translation for a specific field and locale.
     */
    public function setTranslation(string $field, string $locale, ?string $value): void
    {
        Translation::updateOrCreate(
            [
                'locale' => $locale,
                'field' => $field,
                'translatable_type' => get_class($this),
                'translatable_id' => $this->id,
            ],
            [
                'value' => $value,
            ]
        );
    }

    /**
     * Set multiple translations at once.
     */
    public function setTranslations(array $translations, string $locale): void
    {
        foreach ($translations as $field => $value) {
            $this->setTranslation($field, $locale, $value);
        }
    }

    /**
     * Get all translations as array for a specific locale.
     */
    public function getTranslations(string $locale): array
    {
        return $this->translations()
            ->where('locale', $locale)
            ->pluck('value', 'field')
            ->toArray();
    }

    /**
     * Get translatable fields for this model.
     * Override in model if needed.
     */
    public function getTranslatableFields(): array
    {
        return $this->translatable ?? ['title', 'description'];
    }

    /**
     * Accessor for translated title.
     */
    public function getTranslatedTitleAttribute(): ?string
    {
        return $this->translate('title') ?? $this->title;
    }

    /**
     * Accessor for translated description.
     */
    public function getTranslatedDescriptionAttribute(): ?string
    {
        return $this->translate('description') ?? $this->description;
    }
}

