<?php

use App\Models\User;

test('test authenticated user can logout', function () {
    $user = User::factory()->create();

    $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/v1/logout');

    $response->assertStatus(200);
    $response->assertJsonStructure(['message']);
});

test('test user is unauthenticated after logout', function () {
    $user = User::factory()->create();

    $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->postJson('/api/v1/logout');

    $this->assertGuest();
});
