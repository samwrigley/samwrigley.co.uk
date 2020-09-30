<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
            'bio' => $this->faker->paragraph,
            'avatar' => 'https://via.placeholder.com/48',
            'remember_token' => Str::random(10),
        ];
    }
}
