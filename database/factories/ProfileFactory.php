<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->numberBetween(1, 2),
            'date_of_birth' => fake()->dateTimeBetween('-50 years', '-18 years'),
            'location' => fake()->city(),
            'biography' => fake()->text(200),
            'is_active' => true
        ];
    }
}
