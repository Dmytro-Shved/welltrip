<?php

// 1. The Register is success with valid credentials
// 2. The Register returns validation errors 422 with invalid credentials

test('test register returns token with valid credentials', function () {
    $credentials = [
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => 'password12345',
        'password_confirmation' => 'password12345',
    ];

    $response = $this->postJson('/api/v1/register', $credentials);

    $response->assertStatus(201);
    $response->assertJsonStructure(['data', 'access_token']);
    $response->assertJsonPath('data.name', 'User');
    $this->assertNotEmpty($response->json('access_token'));
});

test('test register returns error with invalid credentials', function () {
    $credentials = [
        'name' => 'User',
        'email' => 'wrongEmailType',
        'password' => '1111111111',
        'password_confirmation' => '0000000000',
    ];

    $response = $this->postJson('/api/v1/register', $credentials);

    $response->assertStatus(422);
});
