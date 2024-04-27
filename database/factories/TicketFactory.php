<?php

namespace Database\Factories;

use App\Models\PaymentInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'issue_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'checkin_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'trip_id' => function () {
                return \App\Models\Trip::get()->random()->id ?? \App\Models\Trip::factory()->create()->id;
            },
            'purchase_location' => $this->faker->randomElement(['online', 'counter']),
            'checked_baggage_quantity' => $this->faker->numberBetween(0, 3),
            'checked_baggage_weight' => $this->faker->randomFloat(2, 5, 30),
            'ticket_status' => $this->faker->randomElement(['issued', 'cancelled', 'used']),
            'ticket_number' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'booking_code' => $this->faker->unique()->regexify('[A-Z0-9]{6}'),
        ];
    }
}
