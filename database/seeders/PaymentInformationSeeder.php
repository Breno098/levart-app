<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\PaymentInformation;
use App\Models\PaymentMethod;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creditCard = PaymentMethod::create(['name' => 'Credit Card']);

        foreach (range(0, 10) as $key => $value) {
            PaymentInformation::factory()->create([
                'payment_method_id' => $creditCard->id,
            ]);
        }

        $debitCard = PaymentMethod::create(['name' => 'Debit Card']);

        foreach (range(0, 10) as $key => $value) {
            PaymentInformation::factory()->create([
                'payment_method_id' => $debitCard->id,
            ]);
        }

        $payment = PaymentMethod::create(['name' => 'PayPal']);

        foreach (range(0, 10) as $key => $value) {
            PaymentInformation::factory()->create([
                'payment_method_id' => $payment->id,
            ]);
        }

        PaymentInformation::chunk(10, function ($paymentInformation) {
            foreach ($paymentInformation as $paymentInformationOne) {
                $ticket = Ticket::factory()->state([
                    'payment_information_id' => $paymentInformationOne->id,
                ])->create();

                Passenger::factory()
                    ->count(rand(1, 3))
                    ->create()
                    ->each(function(Passenger $passenger) use ($ticket) {
                        $ticket->passengers()->attach($passenger, [
                            'seat_type' => fake()->randomElement(['economy', 'business', 'first_class']),
                            'seat_number' => fake()->unique()->randomNumber(3),
                        ]);
                    });
            }
        });
    }
}
