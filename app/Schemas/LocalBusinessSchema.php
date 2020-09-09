<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\Schema;

class LocalBusinessSchema implements SchemaContract
{
    public function generate(): LocalBusiness
    {
        return Schema::localBusiness()
            ->description(Config::get('meta.description'))
            ->name(Config::get('app.name'))
            ->image(asset('images/sam-wrigley.png'))
            ->telephone(Config::get('contact.telephone'))
            ->sameAs($this->generateSameAs());
    }

    private function generateSameAs(): array
    {
        return [
            'https://twitter.com/' . Config::get('social.twitter'),
            'https://instagram.com/' . Config::get('social.instagram'),
            'https://github.com/' . Config::get('social.instagram'),
        ];
    }
}
