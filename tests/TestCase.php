<?php

namespace Developvi\LaravelSlugI18n\Tests;

use Developvi\LaravelSlugI18n\SlugI18nServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Sluggable\SluggableServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [SluggableServiceProvider::class, SlugI18nServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('slug-i18n.skip_locales', ['ar', 'fa', 'ur']);
    }
}
