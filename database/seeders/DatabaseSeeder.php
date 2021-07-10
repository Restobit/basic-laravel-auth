<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class); // seed the fix datas to roles table
        $this->call(UsersTableSeeder::class); // seed the fix datas to users table
        // \App\Models\User::factory(5)->create(); //make 5 random user

    }
}
