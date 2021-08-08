<?php

use Illuminate\Database\Seeder;
use App\Role;

class roles_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::Create([
            "rname" => "administrador",
            "slug" => "soy un administrador",
            "description" => "Soy un administrador ",
            "fullaccess" => "yes"
        ]);

        Role::Create([
            "rname" => "vendedor",
            "slug" => "soy un vendedor",
            "description" => "Soy un vendedor ",
            "fullaccess" => "no"
        ]);

        Role::Create([
            "rname" => "clientes",
            "slug" => "soy un clientes",
            "description" => "Soy un clientes",
            "fullaccess" => "no"
        ]);
    }
}
