<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
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

    protected function gate(): void
    {
        Gate::define('viewHorizon', function (User $user): bool {
            return $user->email === Config::get('contact.email');
        });
    }
}
