<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Manually bind Concord contract if not already bound
        if (!$this->app->bound(\Konekt\Concord\Contracts\Concord::class)) {
            $this->app->singleton(
                \Konekt\Concord\Contracts\Concord::class,
                \Konekt\Concord\Concord::class
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
