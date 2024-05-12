<?php

namespace Database\Seeders;

use App\Enums\PaymentMethodEnum;
use App\Models\Passenger;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PaymentMethodEnum::toValues() as $paymentMethod) {
            Ticket::factory()
                ->state(['payment_method' => $paymentMethod])
                ->count(5)
                ->create();
        }

        Ticket::get()->each(function(Ticket $ticket) {
            $passengers = Passenger::factory()->count(rand(1, 3))->create();

            foreach ($passengers as $passenger) {
                $ticket->passengers()->attach($passenger, [
                    'seat_type' => fake()->randomElement(['economy', 'business', 'first_class']),
                    'seat_number' => fake()->randomElement(range(1, 50)),
                ]);
            }
        });
    }
}
