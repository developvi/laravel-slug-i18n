<?php

namespace Developvi\LaravelSlugI18n\Tests;

use Developvi\LaravelSlugI18n\Sluggable\GenerateSlugI18nAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SpatieSluggableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
        });
    }

    public function test_it_registers_the_i18n_action()
    {
        $this->assertSame(GenerateSlugI18nAction::class, config('sluggable.actions.generate_slug'));
    }

    public function test_it_keeps_arabic_letters_and_stays_unique()
    {
        $first = Article::create(['title' => 'سماعات لاسلكية']);
        $second = Article::create(['title' => 'سماعات لاسلكية']);

        $this->assertSame('سماعات-لاسلكية', $first->slug);
        $this->assertSame('سماعات-لاسلكية-1', $second->slug);
    }

    public function test_english_is_still_transliterated()
    {
        $this->assertSame('wireless-headphones', ArticleEn::create(['title' => 'Wireless Headphones'])->slug);
    }

    public function test_an_app_defined_action_is_not_overridden()
    {
        config(['sluggable.actions.generate_slug' => CustomAction::class]);

        (new \Developvi\LaravelSlugI18n\SlugI18nServiceProvider($this->app))->boot();

        $this->assertSame(CustomAction::class, config('sluggable.actions.generate_slug'));
    }
}

class Article extends Model
{
    use HasSlug;

    public $timestamps = false;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->usingLanguage('ar');
    }
}

class ArticleEn extends Article
{
    protected $table = 'articles';

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
}

class CustomAction extends GenerateSlugI18nAction
{
}
