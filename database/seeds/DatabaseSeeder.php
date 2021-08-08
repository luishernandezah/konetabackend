<?php

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
        $this->call(permisos_seeder::class);
        $this->call(roles_seeder::class);
        $this->call(users_seeder::class);
       
        // $this->call(UserSeeder::class);
    }
}
