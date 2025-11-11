<?php

// 1. The Login is success with valid credentials
// 2. The Login returns validation errors 422 with invalid credentials

use App\Models\User;

test('test login returns token with valid credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password', // default password in the UserFactory
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['access_token']);
});

test('test login returns error with invalid credentials', function () {
    $response = $this->postJson('/api/v1/login', [
        'email' => 'noneexisting@gmail.com',
        'password' => 'password',
    ]);

    $response->assertStatus(422);
});
