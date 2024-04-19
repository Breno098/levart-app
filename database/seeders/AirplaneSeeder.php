<?php

namespace Database\Seeders;

use App\Models\Airplane;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirplaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Airplane::factory()->count(5)->create();
    }
}
