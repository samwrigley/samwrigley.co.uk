<?php

namespace App\Schemas;

use App\Schemas\Contracts\SchemaContract;
use App\Schemas\LocalBusinessSchema;
use App\Schemas\PersonSchema;
use App\Schemas\WebsiteSchema;
use Spatie\SchemaOrg\Graph;

class SiteSchema implements SchemaContract
{
    public function generate(): Graph
    {
        $siteSchema = new Graph();
        $websiteSchema = new WebsiteSchema();
        $personSchema = new PersonSchema();
        $localBusinessSchema = new LocalBusinessSchema();

        $siteSchema
            ->add($websiteSchema->generate())
            ->add($personSchema->generate())
            ->add($localBusinessSchema->generate());

        return $siteSchema;
    }
}
