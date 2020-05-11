<?php

namespace Tests\Unit\Schemas;

use App\Schemas\SiteSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\WebSite;
use Tests\TestCase;

class SiteSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_site_schema(): void
    {
        $siteSchema = (new SiteSchema())->generate();

        $this->assertInstanceOf(Person::class, $siteSchema[Person::class]);
        $this->assertInstanceOf(WebSite::class, $siteSchema[WebSite::class]);
        $this->assertInstanceOf(LocalBusiness::class, $siteSchema[LocalBusiness::class]);
    }
}
