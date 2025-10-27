<?php

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;

test('test public user cannot access adding travel', function () {
    $response = $this->postJson('/api/v1/admin/travels');

    $response->assertStatus(401);
});

test('test non admin user cannot access adding travel', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', '!=', 'admin')->value('id'));
    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels');

    $response->assertStatus(403);
});

test('test saves travel successfully with valid data', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'admin')->value('id'));

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
        'name' => 'My New Travel',
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
        'is_public' => 1,
        'name' => 'My New Travel',
        'description' => 'Road To The Heaven',
        'number_of_days' => 5,
    ]);

    $response->assertStatus(201);

    $response = $this->get('/api/v1/travels');
    $response->assertJsonFragment(['name' => 'My New Travel']);
});

test('test public user cannot access updating travel', function () {
    $travel = Travel::factory()->create();
    $response = $this->putJson('api/v1/editor/travels/'.$travel->id);

    $response->assertStatus(401);
});

test('test non admin or editor user cannot access editing travel', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::whereNotIn('name', ['admin', 'editor'])->value('id'));
    $travel = Travel::factory()->create();

    $response = $this->actingAs($user)->putJson('api/v1/editor/travels/'.$travel->id);

    $response->assertStatus(403);
});

test('test updates travel successfully with valid data', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'editor')->value('id'));
    $travel = Travel::factory()->create();
    $response = $this->actingAs($user)->putJson('api/v1/editor/travels/'.$travel->id, [
        'name' => 'My Updated Travel',
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson('api/v1/editor/travels/'.$travel->id, [
        'is_public' => 1,
        'name' => 'My Updated Travel',
        'description' => 'Updated Description',
        'number_of_days' => 10,
    ]);

    $response->assertStatus(200);

    $response = $this->get('/api/v1/travels/');
    $response->assertJsonFragment([
        'name' => 'My Updated Travel',
    ]);
});
