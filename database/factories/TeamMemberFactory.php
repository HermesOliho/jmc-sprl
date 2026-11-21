<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->jobTitle(),
            'bio' => fake()->optional()->paragraph(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'social_links' => fake()->optional()->randomElement([
                [
                    ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/'.fake()->userName()],
                ],
                [
                    ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/'.fake()->userName()],
                    ['name' => 'X', 'url' => 'https://x.com/'.fake()->userName()],
                ],
            ]),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
