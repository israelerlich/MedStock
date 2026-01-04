<?php

namespace Database\Seeders;

use App\Models\ProductMovement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductMovement::factory()->count(50)->create();
    }
}
