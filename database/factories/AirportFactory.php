<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airport>
 */
class AirportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company . ' Airport',
            'location_id' => function () {
                return \App\Models\Location::factory()->create()->id;
            },
            'iata_code' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'icao_code' => $this->faker->unique()->regexify('[A-Z]{4}'),
            'runways_number' => $this->faker->numberBetween(1, 5),
        ];
    }
}
