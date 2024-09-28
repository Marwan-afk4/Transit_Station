<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pick_up_address' => fake()->address(),
            'location_image' => fake()->imageUrl(),
            'address' => fake()->address(),
            'address_in_detail' => fake()->address(),
        ];
    }
}
