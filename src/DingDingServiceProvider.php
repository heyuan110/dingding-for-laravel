<?php

namespace PatPat\DingDing;

use Illuminate\Support\ServiceProvider;

class DingDingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //import route
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        //import view
        $this->loadViewsFrom(__DIR__.'/views', 'DingDing');

        //publish
        $this->publishes([
            __DIR__.'/views'             => base_path('resources/views/vendor/dingding-for-laravel'),
            __DIR__.'/config/dingding.php' => config_path('dingding.php'),
        ]);

    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('dingding', function ($app) {
            return new DingDing($app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
