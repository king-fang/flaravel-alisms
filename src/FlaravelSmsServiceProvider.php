<?php

namespace Flaravel;

use Carbon\Laravel\ServiceProvider;

class FlaravelSmsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $source =  realpath(__DIR__.'/alisms.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('alisms.php')], 'flaravel');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('alisms',function($app){
            return new Fsms($app);
        });
    }
}
