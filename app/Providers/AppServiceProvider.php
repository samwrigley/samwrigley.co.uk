<?php

namespace App\Providers;

use App\Providers\DuskServiceProvider;
use App\Providers\TelescopeServiceProvider;
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
        if ($this->app->isLocal()) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
