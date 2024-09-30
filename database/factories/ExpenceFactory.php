<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expence>
 */
class ExpenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_expence_id'=>fake()->numberBetween(1,10),
            'expence_amount'=>fake()->randomDigit(),
            'date'=>fake()->date()
        ];
    }
}
