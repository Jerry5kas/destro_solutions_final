<?php

/**
 * Helper function to get translated content dynamically.
 * 
 * Usage:
 * t($contentItem, 'title') - Get translated title
 * t($contentItem, 'description', 'de') - Get German translation
 */
if (!function_exists('t')) {
    function t($model, string $field, ?string $locale = null): ?string
    {
        if (!$model instanceof \Illuminate\Database\Eloquent\Model) {
            return null;
        }

        // Check if model uses Translatable trait
        if (method_exists($model, 'translate')) {
            return $model->translate($field, $locale);
        }

        // Fallback to TranslationService
        $translationService = app(\App\Services\TranslationService::class);
        return $translationService->getTranslation($model, $field, $locale);
    }
}

/**
 * Helper function to get translated content with fallback to original.
 */
if (!function_exists('translated')) {
    function translated($model, string $field, ?string $locale = null): string
    {
        $translation = t($model, $field, $locale);
        return $translation ?? $model->getAttribute($field) ?? '';
    }
}

