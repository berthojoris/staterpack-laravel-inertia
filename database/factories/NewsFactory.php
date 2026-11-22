<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\News>
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
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => str($title)->slug()->append('-'.fake()->unique()->numberBetween(100, 999)),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(4, true),
            'author' => fake()->name(),
            'image_url' => 'https://picsum.photos/seed/'.str()->random(8).'/800/450',
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
