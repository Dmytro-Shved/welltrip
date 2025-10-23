<?php

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;

test('test public user cannot access adding tour', function () {
    $travel = Travel::factory()->create();
    $response = $this->postJson('api/v1/admin/travels/'.$travel->id.'/tours');

    $response->assertStatus(401);
});

test('test non admin user cannot access adding tour', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', '!=', 'admin')->value('id'));
    $travel = Travel::factory()->create();
    $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours');

    $response->assertStatus(403);
});

test('test saves tour successfully with valid data', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'admin')->value('id'));
    $travel = Travel::factory()->create();
    $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours', [
        'name' => 'My First Tour',
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours', [
        'name' => 'My First Tour',
        'starting_date' => now(),
        'ending_date' => now()->addDays(rand(1, 10)),
        'price' => 100,
    ]);

    $response->assertStatus(201);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');
    $response->assertJsonFragment(['name' => 'My First Tour']);
});
