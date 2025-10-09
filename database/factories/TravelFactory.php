<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TravelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(asText: true);
        $numberOfDays = random_int(3,10);

        return [
            'name' => $name,
            'description' => fake()->words(asText: true),
            'number_of_days' => $numberOfDays,
        ];
    }
}
