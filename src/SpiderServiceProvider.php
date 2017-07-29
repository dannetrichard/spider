<?php

namespace Dannetrichard\Spider;

use Illuminate\Support\ServiceProvider;

class SpiderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/spider.php' => config_path('spider.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/models' => app_path(),
            __DIR__.'/controllers' => app_path('Http/Controllers'),
        ]);        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Spider::class, function () {
            return new Spider();
        });
        $this->app->alias(Spider::class, 'Spider');
    }
}
