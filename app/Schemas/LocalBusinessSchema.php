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
            ->description(Config::get('meta.tagline'))
            ->name('Sam Wrigley')
            ->image(asset('images/sam-wrigley.png'))
            ->telephone(Config::get('contact.telephone'))
            ->openingHours('Mo,Tu,We,Th,Fr 09:00-18:00')
            ->sameAs([
                'https://twitter.com/' . Config::get('social.twitter'),
                'https://instagram.com/' . Config::get('social.instagram'),
                'https://github.com/' . Config::get('social.instagram'),
            ]);
    }
}
