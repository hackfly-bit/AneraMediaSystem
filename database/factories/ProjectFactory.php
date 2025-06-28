<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'in_progress', 'completed']),
            'budget' => fake()->numberBetween(10000000, 500000000), // 10M to 500M IDR
            'progress_percentage' => fake()->numberBetween(0, 100),
            'deadline' => fake()->dateTimeBetween('now', '+1 year'),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}