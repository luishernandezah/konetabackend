<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class rolesController extends Controller
{


    public function rutaprincipales()
    {
        $resultado = Auth()->user()->roles;

        foreach ($resultado  as $descp) {
            $fors = $descp->rname;
        }
        if ($fors == "administrador") {
            return $this->superadmin();;
        } else {
            return $this->rutausuarios($resultado);
        }
        //  return response()->json( $datos );
    }

    public  function rutausuarios($resultado)
    {
        try {
            $datos = array();
            foreach ($resultado  as $descp) {
                $fors = array("roles" => $descp->rname);
                array_push($datos, $fors);
            }
            foreach ($resultado as $roles) {
                $role = Role::with("permisos")->where('rname', $roles->rname)->get();
                foreach ($role as $permiso) {
                    $permi = $permiso->permisos;
                }
            }
            foreach ($permi as $rutas) {
                if ($rutas["menu"] == "yes") {
                    array_push($datos, $rutas);
                }
            }
            return $datos;
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    function superadmin()
    {
        try {
            $datos = array();
            $permiso = Permiso::all();
            foreach ($permiso as $rutas) {
                if ($rutas["menu"] == "yes") {
                    array_push($datos, $rutas);
                }
            }
            return $datos;
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            Gate::authorize('permisosadmin', [["rolespermisos"]]);
            $permiso = Permiso::get();
            $roles = Role::with("permisos")->get();
            return response()->json(["roles" => $roles, "permiso" => $permiso], 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {

            $roles =  Role::find($id);

            $si = $roles->permisos()->sync($request->permiso);
            if ($si) {
                return response()->json(["message" => "Se ha actualizado con éxito."], 201);
            }
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
