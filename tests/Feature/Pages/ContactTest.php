<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function can_visit_contact_view(): void
    {
        $this->get(route('contact'))->assertOk();
    }

    /** @test */
    public function can_get_in_contact_with_valid_fields(): void
    {
        $this->followingRedirects()
            ->from('contact')
            ->getContactRoute([
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'message' => $this->faker->sentence,
            ])
            ->assertViewIs('pages.contact')
            ->assertSessionHasNoErrors()
            ->assertOk();
    }

    /** @test */
    public function email_is_required(): void
    {
        $data = [
            'name' => $this->faker->name,
            'message' => $this->faker->sentence,
        ];

        $this->getContactRoute($data)
            ->assertRedirect()
            ->assertSessionHasErrorsIn('contact', 'email')
            ->assertSessionDoesntHaveErrors(['name', 'message'], null, 'contact')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function valid_email_is_required(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->sentence,
            'message' => $this->faker->sentence,
        ];

        $this->getContactRoute($data)
            ->assertRedirect()
            ->assertSessionHasErrorsIn('contact', 'email')
            ->assertSessionDoesntHaveErrors(['name', 'message'], null, 'contact')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function name_is_required(): void
    {
        $data = [
            'email' => $this->faker->email,
            'message' => $this->faker->sentence,
        ];

        $this->getContactRoute($data)
            ->assertRedirect()
            ->assertSessionHasErrorsIn('contact', 'name')
            ->assertSessionDoesntHaveErrors(['email', 'message'], null, 'contact')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function message_is_required(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this->getContactRoute($data)
            ->assertRedirect()
            ->assertSessionHasErrorsIn('contact', 'message')
            ->assertSessionDoesntHaveErrors(['name', 'email'], null, 'contact')
            ->assertSessionHasInput($data);
    }

    private function getContactRoute(array $parameters = []): TestResponse
    {
        return $this->post(
            route('contact.store', $parameters)
        );
    }
}
