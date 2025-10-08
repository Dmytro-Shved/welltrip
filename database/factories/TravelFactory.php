<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class TravelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(asText: true);
        $numberOfDays = random_int(3,10);

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'description' => fake()->words(asText: true),
            'numberOfDays' => $numberOfDays,
            'numberOfNights' => $numberOfDays - 1,
        ];
    }
}
