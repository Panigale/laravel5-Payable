<?php
/**
 * Author: Panigale
 * Date: 2018/2/26
 * Time: 下午3:00
 */

namespace Panigale\Payment;


use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigration();
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
     * add migration
     */
    private function loadMigration()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}