<?php

namespace Webkul\Property\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\Property\Repositories\PropertyRepository;
use Webkul\Property\Repositories\PropertyInventoryRepository;

class PropertyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PropertyRepository::class, function ($app) {
            return new PropertyRepository($app);
        });

        $this->app->bind(PropertyInventoryRepository::class, function ($app) {
            return new PropertyInventoryRepository($app);
        });
    }
}