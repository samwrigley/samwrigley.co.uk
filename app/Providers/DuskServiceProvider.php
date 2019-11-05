<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Browser::macro('hasElement', function (string $element) {
            return $this->driver->executeScript("return document.querySelector('{$element}') != null;");
        });
    }
}
