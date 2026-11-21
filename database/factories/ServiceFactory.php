<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
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
            'description' => fake()->sentence(18),
            'icon' => fake()->randomElement(['building2', 'hard-hat', 'zap', 'landmark', 'globe']),
            'deliverables' => [fake()->sentence(4), fake()->sentence(4), fake()->sentence(4)],
            'benefits' => [fake()->words(2, true), fake()->words(2, true)],
            'is_featured' => false,
            'home_sort_order' => 0,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
            'image_alt' => null,
            'image_position' => 'center',
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function featured(int $homeOrder = 0): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'home_sort_order' => $homeOrder,
        ]);
    }
}
