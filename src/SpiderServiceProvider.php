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
