<?php

use Illuminate\Database\Seeder;
use App\User;

class users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user1 = User::Create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => "12345678",
            "documento" => 12345678,
            "direccion" => "Colombia"
        ]);

        $user2 = User::Create([
            "name" => "vendedor",
            "email" => "vendedor@vendedor.com",
            "password" => "12345678",
            "documento" => 43215678,
            "direccion" => "Colombia"
        ]);

        $user3 = User::Create([
            "name" => "clients",
            "email" => "clients@clients.com",
            // "password"=>"12345678",
            "documento" => 87654321,
            "direccion" => "Colombia"
        ]);
        //
        $user1->roles()->sync([1]);
        $user2->roles()->sync([2]);
        $user3->roles()->sync([3]);
    }
}
