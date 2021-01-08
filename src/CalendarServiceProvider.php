<?php

namespace ServiceTime\Calendar;

use Illuminate\Support\ServiceProvider;
use ServiceTime\Calendar\Services\HttpClient\Clients\GuzzleHttpClient;
use ServiceTime\Calendar\Services\HttpClient\Clients\IHttpClient;
use ServiceTime\Calendar\Services\Providers\Clients\IProviderClient;
use ServiceTime\Calendar\Services\Providers\Clients\ServiceTimeProviderClient;

class CalendarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IHttpClient::class, GuzzleHttpClient::class);
        $this->app->bind(IProviderClient::class, ServiceTimeProviderClient::class);
    }

    public function boot()
    {
        /**
         * Views
         */
        $this->loadRoutesFrom(__DIR__."/../routes/web.php");
        $this->loadViewsFrom(__DIR__."/views/calendar", "service-time-calendar");

        /**
         * js, css
         */
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/service-time-calendar')
        ], 'service-time-calendar-assert');

        /**
         * config
         */
        $this->publishes([
            __DIR__.'/../config/serviceTime.php' => config_path("serviceTimeConfig.php")
        ], 'service-time-calendar-config');
        $this->mergeConfigFrom(
            __DIR__.'/../config/serviceTime.php', "service-time-calendar"
        );
    }
}