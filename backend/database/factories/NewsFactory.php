<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'author_id' => Author::first()->id,
            'source_id' => Source::first()->id,
            'category_id' => Category::first()->id,
            'image_url' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
