<?php

namespace Tests\Unit\Schemas;

use App\Schemas\LocalBusinessSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    }
}
