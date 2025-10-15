<?php

use App\Models\Travel;
use App\Models\Tour;

test('tours list by travel slug return paginated data correctly', function () {
    $travel = Travel::factory()->create();
    Tour::factory(16)->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/tours/' . $travel->slug);

    $response->assertStatus(200);
    $response->assertJsonCount(15, 'data');
    $response->assertJsonPath('meta.last_page', 2);
});
