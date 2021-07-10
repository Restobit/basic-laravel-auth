<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::find(1);
        $userRole = Role::find(2);


        $user = User::create([
            'name' => 'user',
            'email' => 'user@localhost.hu',
            'password' => Hash::make('barack'),
            'accepted' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
