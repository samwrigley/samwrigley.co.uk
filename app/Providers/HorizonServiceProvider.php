<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeSlackNotificationsTo(
            Config::get('notifications.slack.queue'),
            '#queue'
        );
    }
}
