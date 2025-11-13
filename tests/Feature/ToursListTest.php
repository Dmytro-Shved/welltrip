<?php

use App\Models\Tour;
use App\Models\Travel;

test('test tours list by travel slug returns correct tours', function () {
    $travel = Travel::factory()->create();
    $tour = Tour::factory()->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['id' => $tour->id]);
});

test('test tour price is shown correctly', function () {
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

test('test tours list by travel slug returns paginated data correctly', function () {
    $travel = Travel::factory()->create();
    Tour::factory(16)->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(15, 'data');
    $response->assertJsonPath('meta.last_page', 2);
});

test('test tours list sorts by starting date correctly', function () {
    $travel = Travel::factory()->create();

    $earlierTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now(),
        'ending_date' => now()->addDays(1),
    ]);

    $laterTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now()->addDays(2),
        'ending_date' => now()->addDays(3),
    ]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonPath('data.0.id', $earlierTour->id);
    $response->assertJsonPath('data.1.id', $laterTour->id);
});

test('test tours list sorts by price correctly', function () {
    $travel = Travel::factory()->create();

    $expensiveTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 200,
    ]);

    $cheapLaterTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 100,
        'starting_date' => now()->addDays(2),
        'ending_date' => now()->addDays(3),
    ]);

    $cheapEarlierTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 100,
        'starting_date' => now(),
        'ending_date' => now()->addDays(1),
    ]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours?sortBy=price&sortOrder=asc');

    $response->assertStatus(200);
    $response->assertJsonPath('data.0.id', $cheapEarlierTour->id);
    $response->assertJsonPath('data.1.id', $cheapLaterTour->id);
    $response->assertJsonPath('data.2.id', $expensiveTour->id);
});

test('test tours list filters by starting date correctly', function () {
    $travel = Travel::factory()->create();

    $earlierTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now(),
        'ending_date' => now()->addDays(1),
    ]);

    $laterTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now()->addDays(2),
        'ending_date' => now()->addDays(3),
    ]);

    $endpoint = '/api/v1/travels/'.$travel->slug.'/tours';

    $response = $this->get($endpoint.'?dateFrom='.now());
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['id' => $earlierTour->id]);
    $response->assertJsonFragment(['id' => $laterTour->id]);

    $response = $this->get($endpoint.'?dateFrom='.now()->addDay());
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $earlierTour->id]);
    $response->assertJsonFragment(['id' => $laterTour->id]);

    $response = $this->get($endpoint.'?dateFrom='.now()->addDays(5));
    $response->assertJsonCount(0, 'data');

    $response = $this->get($endpoint.'?dateTo='.now()->addDays(5));
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['id' => $earlierTour->id]);
    $response->assertJsonFragment(['id' => $laterTour->id]);

    $response = $this->get($endpoint.'?dateTo='.now()->addDay());
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $laterTour->id]);
    $response->assertJsonFragment(['id' => $earlierTour->id]);

    $response = $this->get($endpoint.'?dateTo='.now()->subDay());
    $response->assertJsonCount(0, 'data');

    $response = $this->get($endpoint.'?dateFrom='.now()->addDay().'&dateTo='.now()->addDays(5));
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $earlierTour->id]);
    $response->assertJsonFragment(['id' => $laterTour->id]);
});

test('test tours list filters by price correctly', function () {
    $travel = Travel::factory()->create();

    $expensiveTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 200,
    ]);

    $cheapTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 100,
    ]);

    $endpoint = '/api/v1/travels/'.$travel->slug.'/tours';

    $response = $this->get($endpoint.'?priceFrom=100');
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['id' => $cheapTour->id]);
    $response->assertJsonFragment(['id' => $expensiveTour->id]);

    $response = $this->get($endpoint.'?priceFrom=150');
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $cheapTour->id]);
    $response->assertJsonFragment(['id' => $expensiveTour->id]);

    $response = $this->get($endpoint.'?priceFrom=250');
    $response->assertJsonCount(0, 'data');

    $response = $this->get($endpoint.'?priceTo=200');
    $response->assertJsonCount(2, 'data');
    $response->assertJsonFragment(['id' => $cheapTour->id]);
    $response->assertJsonFragment(['id' => $expensiveTour->id]);

    $response = $this->get($endpoint.'?priceTo=150');
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $expensiveTour->id]);
    $response->assertJsonFragment(['id' => $cheapTour->id]);

    $response = $this->get($endpoint.'?priceTo=50');
    $response->assertJsonCount(0, 'data');

    $response = $this->get($endpoint.'?priceFrom=150&priceTo=250');
    $response->assertJsonCount(1, 'data');
    $response->assertJsonMissing(['id' => $cheapTour->id]);
    $response->assertJsonFragment(['id' => $expensiveTour->id]);
});

test('test tour list returns validation errors', function () {
    $travel = Travel::factory()->create();

    $response = $this->getJson('/api/v1/travels/'.$travel->slug.'/tours?dateFrom=abcde');
    $response->assertStatus(422);

    $response = $this->getJson('/api/v1/travels/'.$travel->slug.'/tours?priceFrom=abcde');
    $response->assertStatus(422);
});
