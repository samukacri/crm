<?php

namespace Webkul\Project\Providers;

use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'project');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'project');
        
        // Carrega as migrações do módulo Project
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Carrega os breadcrumbs
        $this->loadBreadcrumbs();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Load breadcrumbs for the module.
     *
     * @return void
     */
    protected function loadBreadcrumbs()
    {
        if (file_exists(__DIR__ . '/../Http/breadcrumbs.php')) {
            require __DIR__ . '/../Http/breadcrumbs.php';
        }
    }
}