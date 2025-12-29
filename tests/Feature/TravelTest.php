<?php

use App\Models\Travel;

test('test returns a single travel resource by its identifier', function () {
    $travel = Travel::factory()->create();
    $response = $this->get('/api/v1/travels/'.$travel->id);

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'id' => $travel->id,
        ],
    ]);
});

test('test returns an error if travel not found', function () {
    $response = $this->get('/api/v1/travels/NON-EXISTING-ID');
    $response->assertStatus(404);
});

