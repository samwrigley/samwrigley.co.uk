<?php

namespace Tests\Unit;

use App\NewsletterSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_get_full_name(): void
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        $subscription = factory(NewsletterSubscription::class)->make([
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $this->assertEquals("{$firstName} {$lastName}", $subscription->fullName);
    }
}
