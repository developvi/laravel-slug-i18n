<?php

namespace Developvi\LaravelSlugI18n;

use Developvi\LaravelSlugI18n\Sluggable\GenerateSlugI18nAction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SlugI18nServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/slug-i18n.php' => config_path('slug-i18n.php'),
        ], 'slug-i18n-config');

        // Extend Str with slugI18n macro
        Str::macro('slugI18n', function ($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at'], $forceSkip = false) {
            return SlugI18n::slug($title, $separator, $language, $dictionary, $forceSkip);
        });

        $this->registerSpatieSluggableAction();
    }

    public function register()
    {
        // Merge package config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/slug-i18n.php',
            'slug-i18n'
        );
    }

    /**
     * Point spatie/laravel-sluggable (v4+) at the i18n slug action, unless the app
     * has already configured its own generate_slug action.
     */
    protected function registerSpatieSluggableAction(): void
    {
        $spatieAction = 'Spatie\\Sluggable\\Actions\\GenerateSlugAction';

        if (! config('slug-i18n.spatie_sluggable', true) || ! class_exists($spatieAction)) {
            return;
        }

        $current = config('sluggable.actions.generate_slug');

        if ($current === null || $current === $spatieAction) {
            config(['sluggable.actions.generate_slug' => GenerateSlugI18nAction::class]);
        }
    }
}
