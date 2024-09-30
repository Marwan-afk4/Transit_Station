<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>fake()->numberBetween(1,10),
            'offer_id'=>fake()->numberBetween(1,10),
            'start_date'=>fake()->date(),
            'end_date'=>fake()->date(),
            'amount'=>fake()->numberBetween(100,200),
            'status'=>fake()->numberBetween(0,1),
        ];
    }
}
