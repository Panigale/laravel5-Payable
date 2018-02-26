<?php

namespace Panigale\GoMyPay;

use Illuminate\Support\ServiceProvider;

class GoMyPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * add configuration.
     */
    private function addConfig()
    {
        $this->publishes([
            __DIR__.'/../config/gomypay.php' => config_path('gomypay.php'),
        ]);
    }
}
