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
                __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
            ]);
            $this->loadRoutesFrom(__DIR__.'/routes.php');
            $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
            $this->loadTranslationsFrom(__DIR__.'/path/to/translations', 'courier');
            $this->publishes([
                __DIR__.'/path/to/translations' => resource_path('lang/vendor/courier'),
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
