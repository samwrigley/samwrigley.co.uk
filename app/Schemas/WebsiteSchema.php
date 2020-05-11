<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\WebSite;

class WebsiteSchema implements SchemaContract
{
    public function generate(): WebSite
    {
        return Schema::website()
            ->url(Config::get('app.url'))
            ->name(Config::get('app.name'))
            ->author($this->generateAuthorSchema())
            ->description(Config::get('meta.description'));
    }

    private function generateAuthorSchema(): Person
    {
        return Schema::person()->name(Config::get('app.name'));
    }
}
