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
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
            __DIR__.'/Models' => app_path(),
            __DIR__.'/Controllers' => app_path('Http/Controllers'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('spider', function () {
            return new Spider();
        });
    }
}
