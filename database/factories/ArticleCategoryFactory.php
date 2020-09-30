<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArticleCategory::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph,
        ];
    }
}
