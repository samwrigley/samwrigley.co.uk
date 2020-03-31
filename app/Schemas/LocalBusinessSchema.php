<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\OpeningHoursSpecification;
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
            ->openingHoursSpecification($this->generateOpeningHoursSpecificationSchema())
            ->sameAs($this->generateSameAs());
    }

    private function generateOpeningHoursSpecificationSchema(): OpeningHoursSpecification
    {
        return Schema::openingHoursSpecification()
            ->dayOfWeek(array_values(Carbon::getDays()))
            ->opens('09:00')
            ->closes('18:00');
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
