<?php

namespace Database\Factories;

use App\Enums\CountryEnum;
use App\Helpers\DataHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->numerify('##########'),
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'identity_document' => $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail,
            'nationality' => $this->faker->randomElement(CountryEnum::toValues()),
        ];
    }
}
