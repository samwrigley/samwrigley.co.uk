<?php

namespace Tests\Unit\Schemas;

use App\Schemas\WebsiteSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    }
}
