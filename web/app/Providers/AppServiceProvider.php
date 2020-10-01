<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Flash::levels([
            'success' => 'has-background-success has-text-white',
            'warning' => 'has-background-warning-dark has-text-white',
            'danger' => 'has-background-danger has-text-white',
            'error' => 'has-background-danger has-text-white',
        ]);
    }
}
