<?php

namespace Database\Factories;

use App\Enums\MovementType;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductMovement>
 */
class ProductMovementFactory extends Factory
{
    protected $model = ProductMovement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'client_id' => Client::factory(),
            'type' => fake()->randomElement(MovementType::cases()),
        ];
    }
}
