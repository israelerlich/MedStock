<?php

namespace Database\Factories;

use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductMovement>
 */
class ProductMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'client_id' => \App\Models\Client::factory(),
            'type' => fake()->randomElement(MovementType::cases()),
        ];
    }
}
