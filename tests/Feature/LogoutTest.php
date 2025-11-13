<?php

use App\Models\User;

test('test authenticated user can logout', function () {
    $user = User::factory()->create();

    $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->postJson('/logout');

    $response->assertStatus(200);
    $response->assertJsonStructure(['message']);
});

test('test user is unauthenticated after logout', function () {
    $user = User::factory()->create();

    $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->postJson('/logout');

    $this->assertGuest();
});
