<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
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
            'description' => $this->faker->sentence,
            'departure_airport_id' => function () {
                return \App\Models\Airport::get()->random()->id ?? \App\Models\Airport::factory()->create()->id;
            },
            'departure_gate' => $this->faker->randomElement(['A', 'B', 'C']),
            'destination_airport_id' => function () {
                return \App\Models\Airport::get()->random()->id ?? \App\Models\Airport::factory()->create()->id;
            },
            'destination_gate' => $this->faker->randomElement(['D', 'E', 'F']),
            'airline_id' => function () {
                return \App\Models\Airline::get()->random()->id ?? \App\Models\Airline::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['scheduled', 'cancelled', 'delayed', 'completed']),
            'type' => $this->faker->randomElement(['domestic', 'international']),
            'economic_seats' => $this->faker->numberBetween(50, 200),
            'executive_seats' => $this->faker->numberBetween(10, 50),
            'first_class_seats' => $this->faker->numberBetween(5, 20),
        ];
    }
}
