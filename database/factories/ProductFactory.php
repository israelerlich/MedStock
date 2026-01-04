<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => \App\Models\Supplier::factory(),
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'type' => fake()->randomElement(['medicine', 'equipment', 'supply']),
            'status' => fake()->randomElement(['active', 'inactive', 'discontinued']),
            'expires_at' => fake()->dateTimeBetween(now(), '+2 years'),
        ];
    }
}
