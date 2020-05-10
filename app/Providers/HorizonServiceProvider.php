<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeSlackNotificationsTo(
            'https://hooks.slack.com/services/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',
            '#queue'
        );
    }
}
