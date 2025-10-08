<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function definition(): array
    {
        $randomTravelUuid = Travel::inRandomOrder()->value('uuid');

        return [
            'name' => fake()->words(asText: true),
            'startingDate' => now(),
            'endingDate' => now()->subDay()->addDay(),
            'price' => random_int(1500, 4500),
            'travel_uuid' => $randomTravelUuid
        ];
    }
}
