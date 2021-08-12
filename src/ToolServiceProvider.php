<?php

namespace BinomeWay\NovaPageManagerTool;

use BinomeWay\NovaPageManagerTool\Http\Middleware\Authorize;
use BinomeWay\NovaPageManagerTool\Services\TemplateManager;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ToolServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-page-manager-tool')
            ->hasConfigFile()
            ->hasMigrations([
                'create_pages_table'
            ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function packageBooted()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-page-manager-tool');

        $this->app->booted(function () {
            $this->routes();
        });

        /* Nova::serving(function (ServingNova $event) {
             //
         });*/
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-page-manager-tool')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function packageRegistered()
    {
        $this->app->singleton(TemplateManager::class);
    }


}
