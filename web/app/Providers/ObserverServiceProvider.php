<?php

namespace App\Providers;

use App\Entities\Module;
use App\Observers\ModuleObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
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
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Module::observe(ModuleObserver::class);
    }
}
