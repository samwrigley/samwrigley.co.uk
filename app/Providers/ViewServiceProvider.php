<?php

namespace App\Providers;

use App\Schemas\SiteSchema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $siteSchema = new SiteSchema();

        View::share('siteSchema', $siteSchema->generate());
    }
}
