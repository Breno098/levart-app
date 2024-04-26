<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Delta Air Lines',
            'American Airlines',
            'United Airlines',
            'Lufthansa',
            'British Airways',
            'Emirates',
            'Air France',
            'LATAM Airlines',
            'Qantas Airways',
            'Cathay Pacific'
        ];

        foreach ($names as $name) {
            Airline::factory()
                ->state(['name' => $name])
                ->create();
        }

        /** @var Collection */
        $airlines = Airline::all();

        Airport::factory()
            ->count(10)
            ->create()
            ->each(function(Airport $airport) use ($airlines) {
                $airport->airlines()->sync(
                    $airlines->random(rand(1, 5))
                );
            });
    }
}
