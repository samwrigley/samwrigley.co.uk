<?php

namespace Database\Factories;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterSubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsletterSubscription::class;

    public function definition(): array
    {
        $created_at = $this->faker->dateTimeThisYear();
        $unsubscribed_at = $this->faker->boolean(20) ? $this->faker->dateTimeBetween($created_at, 'now') : null;

        return [
            'first_name' => $this->faker->boolean(20) ? $this->faker->firstName : null,
            'last_name' => $this->faker->boolean(20) ? $this->faker->lastName : null,
            'email' => $this->faker->unique()->safeEmail,
            'created_at' => $created_at,
            'unsubscribed_at' => $unsubscribed_at,
        ];
    }

    public function subscribed(): Factory
    {
        return $this->state(function () {
            return [
                'unsubscribed_at' => now(),
            ];
        });
    }

    public function unsubscribed(): Factory
    {
        return $this->state(function () {
            return [
                'unsubscribed_at' => null,
            ];
        });
    }
}
