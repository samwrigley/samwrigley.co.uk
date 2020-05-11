<?php

namespace Tests\Unit\Schemas;

use App\Schemas\WebsiteSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\Website;
use Tests\TestCase;

class WebsiteSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_website_schema(): void
    {
        $websiteSchema = (new WebsiteSchema())->generate();

        $this->assertInstanceOf(Website::class, $websiteSchema);
        $this->assertEquals($websiteSchema['url'], Config::get('app.url'));
        $this->assertEquals($websiteSchema['name'], Config::get('app.name'));
        $this->assertEquals($websiteSchema['author']['name'], Config::get('app.name'));
        $this->assertEquals($websiteSchema['description'], Config::get('meta.description'));
    }
}
