<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class ContactTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * The name of the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'contact';

    public function setUp(): void
    {
        parent::setUp();

        Log::swap(new LogFake);
    }

    /** @test */
    public function can_visit_contact_view(): void
    {
        $this->get(route('contact'))
            ->assertViewIs('pages.contact')
            ->assertOk();
    }

    /** @test */
    public function redirected_back_after_submission_submission(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->sentence,
        ];

        $this->followingRedirects()
            ->from(route('contact'))
            ->postContactRoute($data)
            ->assertViewIs('pages.contact')
            ->assertOk()
            ->assertSeeText('Thank you for getting in touch!');

        Log::assertLoggedMessage('info', "Contact: {$data['email']}");
    }

    /** @test */
    public function session_has_correct_data_after_successful_submission(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->sentence,
        ];

        $this->from(route('contact'))
            ->postContactRoute($data)
            ->assertRedirect(route('contact'))
            ->assertSessionHas('contact', 'Thank you for getting in touch!')
            ->assertSessionHasNoErrors();

        Log::assertLoggedMessage('info', "Contact: {$data['email']}");
    }

    /** @test */
    public function email_is_required(): void
    {
        $data = [
            'name' => $this->faker->name,
            'message' => $this->faker->sentence,
        ];

        $this->from(route('contact'))
            ->postContactRoute($data)
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrorsIn($this->errorBag, 'email')
            ->assertSessionDoesntHaveErrors(['name', 'message'], null, $this->errorBag)
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

        $this->from(route('contact'))
            ->postContactRoute($data)
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrorsIn($this->errorBag, 'email')
            ->assertSessionDoesntHaveErrors(['name', 'message'], null, $this->errorBag)
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function name_is_required(): void
    {
        $data = [
            'email' => $this->faker->email,
            'message' => $this->faker->sentence,
        ];

        $this->from(route('contact'))
            ->postContactRoute($data)
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrorsIn($this->errorBag, 'name')
            ->assertSessionDoesntHaveErrors(['email', 'message'], null, $this->errorBag)
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function message_is_required(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this->from(route('contact'))
            ->postContactRoute($data)
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrorsIn($this->errorBag, 'message')
            ->assertSessionDoesntHaveErrors(['name', 'email'], null, $this->errorBag)
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function data_is_persisted_in_database(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->sentence,
        ];

        $this->postContactRoute($data);

        $this->assertDatabaseHas('contacts', $data);
    }

    protected function postContactRoute(array $data = []): TestResponse
    {
        return $this->post(route('contact.store'), $data);
    }
}
