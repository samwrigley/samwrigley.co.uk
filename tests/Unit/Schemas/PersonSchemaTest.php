<?php

namespace Tests\Unit\Schemas;

use App\Schemas\PersonSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
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
        $this->assertEquals($personSchema['email'], Config::get('contact.email'));
        $this->assertEquals($personSchema['image'], asset('images/sam-wrigley.png'));
        $this->assertEquals($personSchema['name'], Config::get('app.name'));
        $this->assertEquals($personSchema['telephone'], Config::get('contact.telephone'));
        $this->assertEquals($personSchema['url'], Config::get('app.url'));
    }
}
