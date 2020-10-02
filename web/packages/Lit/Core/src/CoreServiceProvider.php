<?php

namespace Lit\Core;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsWithFallbacks();
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
                    Route::get($resourceName . '/config', [$controller, 'config'])->name("crud.{$resourceName}.config");
                    Route::post($resourceName . '/search', [$controller, 'search'])->name("crud.{$resourceName}.search");
                });
            });
        }
    }

    private function loadViewsWithFallbacks() {
        $customCrudFolder = resource_path('views/vendor/lit/crud');

        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customCrudFolder)) {
            $this->loadViewsFrom($customCrudFolder, 'crud');
        }
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/crud'), 'crud');

        // - include helper
        require_once realpath(__DIR__ . '/helpers.php');
    }
}
