<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'title' => Str::title($title),
            'description' => fake()->optional()->sentence(12),
            'location' => fake()->optional()->city(),
            'event_date' => fake()->optional()->dateTimeBetween('-2 years', 'now'),
            'is_published' => false,
            'sort_order' => fake()->numberBetween(0, 100),
            'cover_photo_id' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
        ]);
    }
}
