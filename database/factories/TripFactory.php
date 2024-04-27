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
        $departureTimeCheck = fake()->boolean();

        return [
            'departure_time' => $departureTimeCheck ? fake()->dateTimeBetween('now', '+1 month') : null,
            'estimated_departure_time' => fake()->dateTimeBetween('now', '+1 month'),
            'arrival_time' => $departureTimeCheck && fake()->boolean() ? fake()->dateTimeBetween('+1 hour', '+3 hours') : null,
            'estimated_arrival_time' => fake()->dateTimeBetween('+1 hour', '+3 hours'),
            'description' => fake()->sentence,
            'departure_airport_id' => function () {
                return \App\Models\Airport::get()->random()->id ?? \App\Models\Airport::factory()->create()->id;
            },
            'departure_gate' => fake()->randomElement(['A', 'B', 'C']),
            'destination_airport_id' => function () {
                return \App\Models\Airport::get()->random()->id ?? \App\Models\Airport::factory()->create()->id;
            },
            'destination_gate' => fake()->randomElement(['D', 'E', 'F']),
            'airline_id' => function () {
                return \App\Models\Airline::get()->random()->id ?? \App\Models\Airline::factory()->create()->id;
            },
            'status' => fake()->randomElement(['scheduled', 'cancelled', 'delayed', 'completed']),
            'type' => fake()->randomElement(['domestic', 'international']),
            'economic_seats' => fake()->numberBetween(50, 200),
            'executive_seats' => fake()->numberBetween(10, 50),
            'first_class_seats' => fake()->numberBetween(5, 20),
        ];
    }
}
