<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Name of the new user');
        $email = $this->ask('Email of the new user');
        $password = $this->secret('Password of the new user');

        $roleNames = Role::all()->pluck('name')->toArray();

        $roleName = $this->choice(
            'Role of the new user',
            $roleNames,
            0
        );

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            $this->info('User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        $roleUuid= Role::where('name', $roleName)->value('id');

        $editorRoleUuid = Role::where('name', 'editor')->value('id');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $user->roles()->attach($roleUuid);

        if ($roleName == 'admin'){
            $user->roles()->attach($editorRoleUuid);
        }

        $this->info('User '.$user->email.' was created successfully');

        return 1;
    }
}
