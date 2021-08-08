<?php

use Illuminate\Database\Seeder;
use App\Permiso;

class permisos_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permiso::Create([
            "nombre" => "USUARIOS GUARDAR",
            "slug" => "usersguardar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);
        Permiso::Create([
            "nombre" => "USUARIOS ACTUALIZAR",
            "slug" => "usersactualizar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);


        Permiso::Create([
            "nombre" => "USUARIOS LISTAR",
            "slug" => "userslistar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);

        Permiso::Create([
            "nombre" => "USUARIOS VER",
            "slug" => "usersver",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);



        Permiso::Create([
            "nombre" => "USUARIOS ELIMINAR",
            "slug" => "userseliminar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);


        ////Usarios/////


        ///////cliente///////
        Permiso::Create([
            "nombre" => "CLIENTE GUARDAR",
            "slug" => "clienteguardar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "cliente",
            "menu" => "yes",
            "acceso" => "cliente"
        ]);
        Permiso::Create([
            "nombre" => "CLIENTE LISTAR",
            "slug" => "clientelistar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "cliente",
            "menu" => "yes",
            "acceso" => "cliente"
        ]);

        Permiso::Create([
            "nombre" => "CLIENTE VER",
            "slug" => "clientever",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "cliente",
            "menu" => "yes",
            "acceso" => "cliente"
        ]);

        Permiso::Create([
            "nombre" => "CLIENTE ACTUALIZAR",
            "slug" => "clienteactualizar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "vendedor",
            "menu" => "yes",
            "acceso" => "vendedor"
        ]);
        Permiso::Create([
            "nombre" => "CLIENTE ELIMINAR",
            "slug" => "clienteeliminar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "cliente",
            "menu" => "yes",
            "acceso" => "cliente"
        ]);
        Permiso::Create([
            "nombre" => "CLIENTE BUSCAR",
            "slug" => "clientebuscar",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "users",
            "menu" => "yes",
            "acceso" => "users"
        ]);

        /////////////CONFIGURACION///////////
        Permiso::Create([
            "nombre" => "CONFIGURACION",
            "slug" => "rolespermisos",
            "descripcion" => "",
            "entrada" => "yes",
            "urls" => "rolespermisos",
            "menu" => "yes",
            "acceso" => "users"
        ]);
    }
}
