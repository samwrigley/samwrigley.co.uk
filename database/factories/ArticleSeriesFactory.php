<?php

namespace Database\Factories;

use App\Models\ArticleSeries;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleSeriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArticleSeries::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(5, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
        ];
    }
}
