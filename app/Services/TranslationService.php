<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TranslationService
{
    /**
     * Supported locales.
     */
    protected array $locales = ['en', 'de'];

    /**
     * Auto-create translation entries when a model is created/updated.
     */
    public function syncTranslations(Model $model, ?string $defaultLocale = null): void
    {
        $defaultLocale = $defaultLocale ?? config('app.locale', 'en');
        $translatableFields = $this->getTranslatableFields($model);

        DB::transaction(function () use ($model, $defaultLocale, $translatableFields) {
            foreach ($translatableFields as $field) {
                $originalValue = $model->getOriginal($field) ?? $model->getAttribute($field);
                
                if ($originalValue) {
                    // Create/update translation for default locale
                    Translation::updateOrCreate(
                        [
                            'locale' => $defaultLocale,
                            'field' => $field,
                            'translatable_type' => get_class($model),
                            'translatable_id' => $model->id,
                        ],
                        [
                            'value' => $originalValue,
                            'is_auto' => false,
                            'translated_at' => $originalValue ? now() : null,
                        ]
                    );
                }

                // Create empty translation entries for other locales
                foreach ($this->locales as $locale) {
                    if ($locale !== $defaultLocale) {
                        Translation::firstOrCreate(
                            [
                                'locale' => $locale,
                                'field' => $field,
                                'translatable_type' => get_class($model),
                                'translatable_id' => $model->id,
                            ],
                            [
                                'value' => null, // Empty, admin can fill later
                                'is_auto' => false,
                                'translated_at' => null,
                            ]
                        );
                    }
                }
            }
        });
    }

    /**
     * Get translatable fields for a model.
     */
    protected function getTranslatableFields(Model $model): array
    {
        // Check if model has getTranslatableFields method (from Translatable trait)
        if (method_exists($model, 'getTranslatableFields')) {
            $fields = $model->getTranslatableFields();
            if (is_array($fields)) {
                return $fields;
            }
        }

        // Check if model has translatable property using reflection (for protected properties)
        try {
            $reflection = new \ReflectionClass($model);
            if ($reflection->hasProperty('translatable')) {
                $property = $reflection->getProperty('translatable');
                $property->setAccessible(true);
                $fields = $property->getValue($model);
                if (is_array($fields)) {
                    return $fields;
                }
            }
        } catch (\ReflectionException $e) {
            // If reflection fails, fall through to default
        }

        // Default translatable fields
        return ['title', 'description'];
    }

    /**
     * Get translation for a model field.
     */
    public function getTranslation(
        Model $model,
        string $field,
        ?string $locale = null
    ): ?string {
        $locale = $locale ?? app()->getLocale();

        $translation = Translation::where('translatable_type', get_class($model))
            ->where('translatable_id', $model->id)
            ->where('locale', $locale)
            ->where('field', $field)
            ->first();

        if ($translation && $translation->value) {
            return $translation->value;
        }

        // Fallback to default locale
        $fallbackLocale = config('app.fallback_locale', 'en');
        if ($locale !== $fallbackLocale) {
            $translation = Translation::where('translatable_type', get_class($model))
                ->where('translatable_id', $model->id)
                ->where('locale', $fallbackLocale)
                ->where('field', $field)
                ->first();

            if ($translation && $translation->value) {
                return $translation->value;
            }
        }

        // Fallback to original attribute
        return $model->getAttribute($field);
    }

    /**
     * Bulk update translations.
     */
    public function bulkUpdateTranslations(
        Model $model,
        array $translations,
        string $locale,
        bool $isAuto = false,
        bool $respectLocksForAuto = true
    ): void {
        foreach ($translations as $field => $value) {
            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'field' => $field,
                'translatable_type' => get_class($model),
                'translatable_id' => $model->id,
            ]);

            if ($respectLocksForAuto && $isAuto && $translation->exists && $translation->locked) {
                continue;
            }

            $translation->value = $value;
            $translation->is_auto = $isAuto;
            $translation->translated_at = $value ? now() : null;
            $translation->save();
        }
    }

    /**
     * Delete all translations for a model.
     */
    public function deleteTranslations(Model $model): void
    {
        Translation::where('translatable_type', get_class($model))
            ->where('translatable_id', $model->id)
            ->delete();
    }
}

