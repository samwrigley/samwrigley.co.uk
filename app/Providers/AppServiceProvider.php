<?php

namespace App\Providers;

use App\Providers\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
