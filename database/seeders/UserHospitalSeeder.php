<?php

namespace Database\Seeders;

use App\Models\UserHospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserHospital::factory()->count(15)->create();
    }
}
