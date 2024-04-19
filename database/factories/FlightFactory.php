<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'departure_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'estimated_departure_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'arrival_time' => $this->faker->dateTimeBetween('+1 hour', '+3 hours'),
            'estimated_arrival_time' => $this->faker->dateTimeBetween('+1 hour', '+3 hours'),
            'airplane_id' => function () {
                return \App\Models\Airplane::factory()->create()->id;
            },
            'description' => $this->faker->sentence,
            'departure_airport_id' => function () {
                return \App\Models\Airport::factory()->create()->id;
            },
            'departure_gate' => $this->faker->randomElement(['A', 'B', 'C']),
            'destination_airport_id' => function () {
                return \App\Models\Airport::factory()->create()->id;
            },
            'destination_gate' => $this->faker->randomElement(['D', 'E', 'F']),
            'airline_id' => function () {
                return \App\Models\Airline::factory()->create()->id;
            },
            'flight_number' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{4}'),
            'flight_status' => $this->faker->randomElement(['scheduled', 'cancelled', 'delayed', 'completed']),
            'flight_type' => $this->faker->randomElement(['domestic', 'international']),
            'ticket_price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
