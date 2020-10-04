<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function (): void {
            $this->mapWebRoutes();
            $this->mapBlogRoutes();
            $this->mapContactRoutes();
            $this->mapNewsletterRoutes();
            $this->mapAdminRoutes();
            $this->mapWebhookRoutes();
        });
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapBlogRoutes(): void
    {
        Route::middleware(['web', 'csp'])
            ->namespace($this->namespace)
            ->group(base_path('routes/blog.php'));
    }

    protected function mapContactRoutes(): void
    {
        Route::middleware(['web', 'csp'])
            ->namespace($this->namespace)
            ->group(base_path('routes/contact.php'));
    }

    protected function mapNewsletterRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/newsletter.php'));
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'csp'])
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    protected function mapWebhookRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/webhook.php'));
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function () {
            return Limit::perMinute(60);
        });
    }
}
