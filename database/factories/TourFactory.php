<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function definition(): array
    {
        $randomTravelUuid = Travel::inRandomOrder()->value('id');

        return [
            'travel_id' => $randomTravelUuid,
            'name' => fake()->words(asText: true),
            'starting_date' => now(),
            'ending_date' => now()->subDay()->addDay(),
            'price' => random_int(150, 450),
        ];
    }
}
