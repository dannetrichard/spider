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
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/routes.php' => routes_path('web.php'),
            __DIR__.'/config/spider.php' => config_path('spider.php'),
            __DIR__.'/models' => app_path(),
            __DIR__.'/controllers' => app_path('Http/Controllers'),
            __DIR__.'/commands/Spider.php' => app_path('Console/Commands/Spider.php'),
            __DIR__.'/commands/Kernel.php' => app_path('Console/Kernel.php'),
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
