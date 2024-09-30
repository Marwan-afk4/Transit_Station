<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price'=>fake()->randomDigit(),
            'offer_name'=>fake()->randomElement(['Normal', 'Weekly', 'Monthly', 'Yearly']),
            'duration'=>fake()->randomElement([1, 7, 30, 365]),
        ];
    }
}
