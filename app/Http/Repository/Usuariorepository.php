<?php

namespace App\Http\Repository;

use App\User;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class Usuariorepository
{

    public function __construct()
    {
    }

    public function validacionMessage()
    {
        return [
            'NOMBRE' => "SE REQUIERE NOMBRE MINIMO 4 Y MAXIMO 20  DEBER SER UN TEXTO",
            //'APELLIDO'=>"SE REQUIERE NOMBRE MINIMO 4 Y MAXIMO 20  DEBER SER UN TEXTO",
            'EMAIL' => "SE REQUIERE CORREO ELECTÓNICO MINIMO 3 MAXIMO 20 DEBER SER UN TEXTO",
            'CEDULA' => "SE REQUIERE CORREO ELECTÓNICO MINIMO 7 MAXIMO 12 DEBER SER UN NUMERO",
            "DIRECCIÓN" => "SE REQUIERE DEBER MINIMO 6 Y DEBER SER UN TEXTO",
            "CONTRASEÑA" => "SE REQUIERE DEBER MINIMO 8  MAXIMO 20 Y DEBER SER UN TEXTO"
        ];
    }
    public function valdacioninser($request)
    {

        return   $request->validate([
            "name" => 'required|min:3|max:20',
            "email" => ['required', 'email', Rule::unique('users')->ignore($request->cedula, 'cedula')],
            "documento" => ['required', 'numeric', 'digits_between:6,30', Rule::unique('users')->ignore($request->cedula, 'cedula')],
            "direccion" => 'required|min:3',
            "password" => 'required|min:6',
        ]);
    }
    public function valdacionupdated($request, $id)
    {

        return   $request->validate([
            "name" => 'required|min:3|max:20',
            "email" => ['required', 'email', Rule::unique('users')->ignore($id)],
            "documento" => ['required', 'numeric', 'digits_between:6,30', Rule::unique('users')->ignore($id)],
            "direccion" => 'required|min:3',
            "password" => 'required|min:6',
        ]);
    }
    public function index()
    {
        try {
            $query = DB::table('users')->select("id", "name", "email", "documento", "direccion")->get();
            return response()->json($query, 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function store($request)
    {

        try {
            $this->valdacioninser($request);
            try {

                $sql = DB::table('users')->insert([
                    "name" => $request->name,
                    "email" => $request->email,
                    "documento" => $request->documento,
                    "direccion" => $request->direccion,
                    "password" => Hash::make($request->password),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
                if ($sql) {
                    $user = User::where("documento", $request->documento)->first();
                    $user->roles()->sync($request->role);
                    if ($user) {
                        return response()->json(["message" => "Se ha registrado con éxito."], 201);
                    } else {
                        return response()->json(["message" => "No  Se ha registrado correctamente."], 299);
                    }
                }
            } catch (QueryException $th) {
                return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message" => "Error de validación verifique los datos nuevamente .", "errors" => $exception], 422);
        }
    }

    public function  show($id)
    {

        try {
            $query =   User::with("roles")->where('id', $id)->first();
            return response()->json($query, 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function  edit($id)
    {
        try {
            $query = DB::table('users')->where("id", "=", $id)->select("name", "email", "documento", "direccion");
            return response()->json($query, 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function  update($request, $id)
    {

        try {
            $this->valdacionupdated($request, $id);
            try {
                $sql = DB::table('users')->where("id", "=", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "documento" => $request->documento,
                    "direccion" => $request->direccion,
                    "password" => Hash::make($request->password),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
                if ($sql) {
                    $user = User::where("documento", $request->documento)->first();
                    $user->roles()->sync($request->role);
                    if ($user) {
                        return response()->json(["message" => "Se ha actualizador con éxito."], 201);
                    } else {
                        return response()->json(["message" => "No  Se ha registrado correctamente."], 299);
                    }
                }
            } catch (QueryException $th) {
                return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message" => "Error de validación verifique los datos nuevamente .", "errors" => $exception], 422);
        }
    }
    public function  destroy($id)
    {
        try {
            $sql = DB::table('users')->where("id", "=", $id)->delete();
            if ($sql) {
                return response()->json(["message" => "Se ha Eliminado con éxito."], 201);
            }
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
}
