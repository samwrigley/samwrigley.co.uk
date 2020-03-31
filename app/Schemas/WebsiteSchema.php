<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\WebSite;

class WebsiteSchema implements SchemaContract
{
    public function generate(): WebSite
    {
        return Schema::website()
            ->url(Config::get('app.url'))
            ->name(Config::get('app.name'))
            ->author(Schema::person()->name(Config::get('app.name')))
            ->description(Config::get('meta.description'));
    }
}
