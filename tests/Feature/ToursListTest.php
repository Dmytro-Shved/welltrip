<?php

use App\Models\Travel;
use App\Models\Tour;

test('tours list by travel slug returns correct tours', function () {
    $travel = Travel::factory()->create();
    $tour = Tour::factory()->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['id' => $tour->id]);
});


test('tour price is shown correctly', function () {
    $travel = Travel::factory()->create();
    Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 123.45,
    ]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['price' => '123.45']);
});

test('tours list by travel slug returns paginated data correctly', function () {
    $travel = Travel::factory()->create();
    Tour::factory(16)->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(15, 'data');
    $response->assertJsonPath('meta.last_page', 2);
});
