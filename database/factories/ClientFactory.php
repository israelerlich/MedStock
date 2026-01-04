<?php

namespace Database\Factories;

use App\Enums\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'profession' => fake()->randomElement(Profession::cases()),
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
