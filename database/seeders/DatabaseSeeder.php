<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AddressSeeder::class,
            ClientSeeder::class,
            HospitalSeeder::class,
            LogSeeder::class,
            ProductMovementSeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            UserHospitalSeeder::class,
            UserSeeder::class
        ]);
    }
}
