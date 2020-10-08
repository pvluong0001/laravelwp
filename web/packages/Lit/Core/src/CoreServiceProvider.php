<?php

namespace Lit\Core;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoute();
        $this->mergeConfigFrom(__DIR__ . '/config/core.php', 'core');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsWithFallbacks();
        if(env('APP_ENV') === 'local') {
            $this->app->singleton('databaseManager', function() {
                return DB::connection('mysql')->getDoctrineSchemaManager();
            });

            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }
    }

    private function registerRoute() {
        if(!Route::hasMacro('crud')) {
            Route::macro('crud', function($resourceName, $controller, $prefix = '', $middleware = ['auth']) {
                Route::group([
                    'prefix' => $prefix,
                    'middleware' => $middleware
                ], function() use ($resourceName, $controller) {
                    Route::get($resourceName, [$controller, 'index'])->name("crud.{$resourceName}.index");
                    Route::get($resourceName . '/create', [$controller, 'create'])->name("crud.{$resourceName}.create");
                    Route::post($resourceName . '/create', [$controller, 'store'])->name("crud.{$resourceName}.store");
                    Route::get($resourceName . '/edit/{id}', [$controller, 'edit'])->name("crud.{$resourceName}.edit");
                    Route::get($resourceName . '/config', [$controller, 'config'])->name("crud.{$resourceName}.config");
                    Route::post($resourceName . '/search', [$controller, 'search'])->name("crud.{$resourceName}.search");
                    Route::delete($resourceName . '/delete/{id}', [$controller, 'delete'])->name("crud.{$resourceName}.delete");
                });
            });
        }
    }

    private function loadViewsWithFallbacks() {
        $customCrudFolder = resource_path('views/vendor/lit/crud');
        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customCrudFolder)) {
            $this->loadViewsFrom($customCrudFolder, 'crud');
        } else {
            $this->loadViewsFrom(realpath(__DIR__.'/resources/views/crud'), 'crud');
        }

        $builderFolder = resource_path('views/vendor/lit/builder');
        if (file_exists($builderFolder)) {
            $this->loadViewsFrom($builderFolder, 'builder');
        } else {
            $this->loadViewsFrom(realpath(__DIR__.'/resources/views/builder'), 'builder');
        }

        // - include helper
        require_once realpath(__DIR__ . '/helpers.php');
    }
}
