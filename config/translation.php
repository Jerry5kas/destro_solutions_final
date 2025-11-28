<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Automatic Translation Toggle
    |--------------------------------------------------------------------------
    | Enables queueing of automatic machine translation jobs whenever
    | translatable models are created or updated.
    */
    'auto_translate' => env('AUTO_TRANSLATE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Source Locale
    |--------------------------------------------------------------------------
    | Locale that acts as the source text for machine translation.
    */
    'source_locale' => env('AUTO_TRANSLATE_SOURCE_LOCALE', env('APP_LOCALE', 'en')),

    /*
    |--------------------------------------------------------------------------
    | Supported Target Locales
    |--------------------------------------------------------------------------
    | Only locales included here will receive machine translations when the
    | automation runs.
    */
    'target_locales' => array_filter(array_map('trim', explode(',', env('AUTO_TRANSLATE_TARGET_LOCALES', 'de')))),
];

