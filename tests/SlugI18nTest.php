<?php

namespace Developvi\LaravelSlugI18n\Tests;

use Developvi\LaravelSlugI18n\SlugI18n;

class SlugI18nTest extends TestCase
{
    public function test_arabic_slug_skips_transliteration()
    {
        config(['slug-i18n.skip_locales' => ['ar', 'fa', 'ur']]);

        $arabic = 'مثال على نص عربي';
        $slug = SlugI18n::slug($arabic, '-', 'ar');
        $this->assertEquals('مثال-على-نص-عربي', $slug);
    }

    public function test_english_slug_transliterates()
    {
        config(['slug-i18n.skip_locales' => ['ar', 'fa', 'ur']]);

        $english = 'Example English Text';
        $slug = SlugI18n::slug($english, '-', 'en');
        $this->assertEquals('example-english-text', $slug);
    }

    public function test_force_skip_transliteration()
    {
        $text = 'مثال على نص عربي';
        $slug = SlugI18n::slug($text, '-', 'en', [], true);
        $this->assertEquals('مثال-على-نص-عربي', $slug);
    }
    public function test_dictionary_replacements()
    {
        $text = 'Laravel@10 ❤️';
        $slug = SlugI18n::slug($text, '-', 'en', ['@' => 'at', '❤️' => 'love'], true);
        $this->assertEquals('laravel-at-10-love', $slug);
    }

}
