<?php

namespace BinomeWay\NovaPageManagerTool;

use BinomeWay\NovaPageManagerTool\Commands\TemplateMakeCommand;
use BinomeWay\NovaPageManagerTool\Http\Middleware\Authorize;
use BinomeWay\NovaPageManagerTool\Layouts\TrixLayout;
use BinomeWay\NovaPageManagerTool\Services\PageBuilder;
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
            ->hasViews()
            ->hasCommands([
                TemplateMakeCommand::class,
            ])
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
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-page-manager-tool');

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
        $this->app->singleton(PageBuilder::class, fn() => new PageBuilder(config('nova-page-manager-tool.layouts', [])));
        $this->app->singleton(TemplateManager::class, fn() => new TemplateManager(config('nova-page-manager-tool.templates', [])));
    }


}
