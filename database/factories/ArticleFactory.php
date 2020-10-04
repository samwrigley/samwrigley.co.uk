<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        $created_at = $this->faker->dateTimeThisYear();
        $published_at = $this->faker->boolean(80) ? $this->faker->dateTimeBetween($created_at, 'now') : null;

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraphs(10, true),
            'excerpt' => $this->faker->paragraph,
            'created_at' => $created_at,
            'published_at' => $published_at,
        ];
    }

    public function draft(): Factory
    {
        return $this->state(function () {
            return [
                'published_at' => null,
            ];
        });
    }

    public function scheduled(): Factory
    {
        return $this->state(function () {
            return [
                'published_at' => now()->addWeek(),
            ];
        });
    }

    public function published(): Factory
    {
        return $this->state(function () {
            return [
                'published_at' => now(),
            ];
        });
    }
}
