<?php

namespace Developvi\LaravelSlugI18n\Sluggable;

use Developvi\LaravelSlugI18n\SlugI18n;
use Spatie\Sluggable\Actions\GenerateSlugAction;
use Spatie\Sluggable\SlugOptions;

/**
 * spatie/laravel-sluggable action that slugifies through SlugI18n, so locales listed in
 * slug-i18n.skip_locales (e.g. ar) keep their own letters instead of being transliterated.
 * Uniqueness, suffixes and the rest of spatie's behavior are unchanged.
 */
class GenerateSlugI18nAction extends GenerateSlugAction
{
    public function slugifySource(string $source, SlugOptions $options): string
    {
        return SlugI18n::slug($source, $options->slugSeparator, $options->slugLanguage);
    }
}
