<?php

namespace Tests\Unit\Schemas;

use App\Schemas\LocalBusinessSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\LocalBusiness;
use Tests\TestCase;

class LocalBusinessSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_local_business_schema(): void
    {
        $localBusinessSchema = (new LocalBusinessSchema())->generate();

        $this->assertInstanceOf(LocalBusiness::class, $localBusinessSchema);
        $this->assertEquals($localBusinessSchema['description'], Config::get('meta.description'));
        $this->assertEquals($localBusinessSchema['name'], Config::get('app.name'));
        $this->assertEquals($localBusinessSchema['image'], asset('images/sam-wrigley.png'));
        $this->assertEquals($localBusinessSchema['telephone'], Config::get('contact.telephone'));
    }
}
