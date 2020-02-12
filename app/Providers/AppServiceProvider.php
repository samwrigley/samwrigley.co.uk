<?php

namespace App\Providers;

use App\Providers\DuskServiceProvider;
use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
