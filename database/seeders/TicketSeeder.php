<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\PaymentInformation;
use App\Models\PaymentMethod;
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
        PaymentMethod::create(['name' => 'Credit Card']);

        PaymentMethod::create(['name' => 'Debit Card']);

        PaymentMethod::create(['name' => 'PayPal']);

        PaymentMethod::get()->each(function(PaymentMethod $paymentMethod) {
            Ticket::factory()
                ->state(['payment_method_id' => $paymentMethod->id])
                ->count(5)
                ->create();
        });
      
        Passenger::factory()
            ->count(rand(1, 5))
            ->create()
            ->each(function(Passenger $passenger) {
                $ticket = Ticket::get()->random();

                $ticket->passengers()->attach($passenger, [
                    'seat_type' => fake()->randomElement(['economy', 'business', 'first_class']),
                    'seat_number' => fake()->unique()->randomNumber(3),
                ]);
            });
    }
}
