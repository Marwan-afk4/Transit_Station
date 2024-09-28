<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::factory(),
            'car_number' => fake()->randomNumber(5),
            'car_name' => $this->faker->randomElement([
                'Toyota Corolla',
                'Honda Civic',
                'Ford Mustang',
                'Chevrolet Impala',
                'BMW 3 Series',
                'Audi A4',
                'Mercedes-Benz C-Class',
                'Nissan Altima',
                'Hyundai Elantra',
                'Kia Sorento'
            ]),
            'car_image' => fake()->imageUrl(),
        ];
    }
}
