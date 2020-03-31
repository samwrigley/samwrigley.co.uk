<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

class PersonSchema implements SchemaContract
{
    public function generate(): Person
    {
        return Schema::person()
            ->email(Config::get('contact.email'))
            ->image(asset('images/sam-wrigley.png'))
            ->jobTitle('Web-Developer')
            ->name(Config::get('app.name'))
            ->alumniOf('Falmouth University')
            ->gender('male')
            ->nationality('British')
            ->telephone(Config::get('contact.telephone'))
            ->url(Config::get('app.url'))
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
