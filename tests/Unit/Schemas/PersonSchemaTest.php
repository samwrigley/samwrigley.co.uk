<?php

namespace Tests\Unit\Schemas;

use App\Schemas\PersonSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\SchemaOrg\Person;
use Tests\TestCase;

class PersonSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_person_schema(): void
    {
        $personSchema = (new PersonSchema())->generate();

        $this->assertInstanceOf(Person::class, $personSchema);
    }
}
