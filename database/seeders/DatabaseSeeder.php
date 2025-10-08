<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Travel;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public array $roles = [
        'user',
        'admin',
        'editor',
    ];

    public function run(): void
    {
        foreach ($this->roles as $role){
            Role::create([
                'name' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $users = User::factory(3)->create();

        $userRoleUuid = Role::where('name', 'user')->value('uuid');
        $adminRoleUuid = Role::where('name', 'admin')->value('uuid');
        $editorRoleUuid = Role::where('name', 'editor')->value('uuid');

        $users->take(2)->each(function ($user) use ($userRoleUuid){
            $user->roles()->attach($userRoleUuid);
        });

        $adminUser = $users->last();
        $adminUser->roles()->attach([$adminRoleUuid, $editorRoleUuid]);

        Travel::factory(5)->create();
        Tour::factory(5)->create();
    }
}
