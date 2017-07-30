<?php

namespace Dannetrichard\Spider;

use Illuminate\Support\ServiceProvider;

use Dannetrichard\Spider\Commands\SpiderCommand;

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
            __DIR__.'/models' => app_path(),
            __DIR__.'/controllers' => app_path('Http/Controllers'),
            __DIR__.'/seeds' => base_path('database/seeds'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                SpiderCommand::class,
            ]);
        }        
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
