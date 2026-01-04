<?php

namespace Database\Factories;

use App\Enums\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'referring_type' => fake()->randomElement(['App\\Models\\User', 'App\\Models\\Supplier']),
            'referring_id' => 1,
            'cep' => fake()->numerify('#####-###'),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'district' => fake()->word(),
            'country' => fake()->randomElement(['br', 'us', 'ca']),
            'street' => fake()->streetName(),
            'complement_number' => fake()->buildingNumber(),
            'address_number' => fake()->buildingNumber(),
        ];
    }
}
