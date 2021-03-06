<?php

namespace Sosek\RssReader;

use Illuminate\Support\ServiceProvider;

class RssReaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rss-reader');

        $this->publishes([
            __DIR__.'/../resources/views/' => base_path('resources/views/vendor/rss-reader'),
            __DIR__.'/../resources/assets/' => public_path('vendor/rss-reader'),
            __DIR__.'/../config/config.php' => config_path('rss-reader.php'),
            __DIR__.'/../migrations/' => database_path('migrations'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //register routes under namespace
        $this->app['router']->group(['namespace' => 'Sosek\RssReader'], function () {
            require __DIR__.'/routes.php';
        });
    }
}
