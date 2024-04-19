<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airplane>
 */
class AirplaneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'brand' => $this->faker->company,
            'manufacture_year' => $this->faker->year,
            'serial_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'cargo_capacity_kg' => $this->faker->numberBetween(1000, 5000),
            'economic_seats' => $this->faker->numberBetween(50, 200),
            'executive_seats' => $this->faker->numberBetween(10, 50),
            'first_class_seats' => $this->faker->numberBetween(5, 20),
        ];
    }
}
