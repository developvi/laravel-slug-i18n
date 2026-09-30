<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Slug I18n
    |--------------------------------------------------------------------------
    |
    | Set SLUG_I18N_ENABLED=true in your .env file to enable this feature.
    |
    */
    'enabled' => env('SLUG_I18N_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Skip Transliteration Locales
    |--------------------------------------------------------------------------
    |
    | Set SLUG_I18N_SKIP_LOCALES in your .env file as a comma-separated list.
    | Example: SLUG_I18N_SKIP_LOCALES=ar,fa,ur
    |
    */
    'skip_locales' =>  [
        ...array_filter(
            explode(',', (string) env('SLUG_I18N_SKIP_LOCALES', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | spatie/laravel-sluggable Integration
    |--------------------------------------------------------------------------
    |
    | When spatie/laravel-sluggable (v4+) is installed, its generate_slug action
    | is swapped for one that slugifies through SlugI18n, so models using HasSlug
    | keep Arabic (and other skipped locales) slugs. An app-defined action is
    | never overridden. Set SLUG_I18N_SPATIE_SLUGGABLE=false to disable.
    |
    */
    'spatie_sluggable' => env('SLUG_I18N_SPATIE_SLUGGABLE', true),
];
