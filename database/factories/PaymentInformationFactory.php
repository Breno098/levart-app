<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentInformation>
 */
class PaymentInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_method_id' => function () {
                return \App\Models\PaymentMethod::factory()->create()->id;
            },
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
        ];
    }
}
