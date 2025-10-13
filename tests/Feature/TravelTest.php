<?php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gets public list of paginated travels', function () {
    $response = $this->get('/api/v1/travels');

    $response->assertStatus(200);

    $response->assertJson([
        'data' => [],
        'links' => [],
        'meta' => []
    ]);
});
