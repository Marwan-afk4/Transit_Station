<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Parking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parking_id'=>Parking::factory(),
            'location_id'=>Location::factory(),
            'name'=>fake()->name(),
            'email'=>fake()->safeEmail(),
            'phone'=>fake()->phoneNumber(),
            'password'=>Hash::make('password'),
            'image'=>fake()->imageUrl(),
            'salary'=>fake()->numberBetween(1000,2000),
            'cars_per_mounth'=>fake()->numberBetween(10,20),
        ];
    }
}
