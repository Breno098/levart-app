<?php

namespace Database\Factories;

use App\Enums\CountryEnum;
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
            'iata_code' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'icao_code' => $this->faker->unique()->regexify('[A-Z]{4}'),
            'city' => $this->faker->city,
            'country' => $this->faker->randomElement(CountryEnum::toValues()),
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
        ];
    }
}
