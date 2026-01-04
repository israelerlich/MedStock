<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'commercial_name' => fake()->word() . ' ' . fake()->word(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
        ];
    }
}
