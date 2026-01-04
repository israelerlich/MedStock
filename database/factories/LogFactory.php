<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->boolean(70) ? \App\Models\User::factory() : null,
            'action' => fake()->randomElement([1, 2, 3, 4]),
            'description' => fake()->sentence(),
            'type' => fake()->randomElement([1, 2, 3]),
        ];
    }
}
