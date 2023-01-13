<?php

namespace Ipregistry\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Ipregistry\Laravel\GetCurrentLocation;
class IpRegistryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('get_current_location', function($app){//
            return new GetCurrentLocation($app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('get_current_location', function($app){
            return new GetCurrentLocation($app);
        });
    }
}
