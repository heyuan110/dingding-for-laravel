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
        //publish
        $this->publishes([
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
