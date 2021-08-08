<?php

namespace App\Http\Repository;

use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Validation\Rule;

class Clienterepository
{
    private $id = 3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
    }

    public function valdacioninser($request)
    {

        return   $request->validate([
            "name" => 'required|min:3|max:20',
            "email" => ['required', 'email', Rule::unique('users')->ignore($request->cedula, 'cedula')],
            "documento" => ['required', 'numeric', 'digits_between:6,30', Rule::unique('users')->ignore($request->cedula, 'cedula')],
            "direccion" => 'required|min:3',

        ]);
    }
    public function valdacionupdate($request, $id)
    {

        return   $request->validate([
            "name" => 'required|min:3|max:20',
            "email" => ['required', 'email', Rule::unique('users')->ignore($id)],
            "documento" => ['required', 'numeric', 'digits_between:6,30', Rule::unique('users')->ignore($id)],
            "direccion" => 'required|min:3',
        ]);
    }
    public function index()
    {


        try {
            $query = DB::table('users')->join("users_roles", "users_roles.user_id", "=", "users.id")
                ->join("roles", "roles.id", "=", "users_roles.role_id")
                ->where("roles.id", "=", $this->id)->get();
            return response()->json($query, 201);
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
                if ($sql) {
                    $user = User::where("documento", $request->documento)->first();
                    $user->roles()->sync($this->id);
                    return response()->json(["message" => "Se ha registrado con éxito."], 201);
                }
            } catch (QueryException $th) {
                return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message" => "Error de validación verifique los datos nuevamente .", "errors" => $exception], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $query =  $this->consulta($id);
            return response()->json($query, 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }


    private function consulta($id)
    {
        try {

            $query = DB::table('users')->join("users_roles", "users_roles.user_id", "=", "users.id")
                ->join("roles", "roles.id", "=", "users_roles.role_id")
                ->where("roles.id", "=", $this->id)->where("users.id", "=", $id)->get();
            return $query;
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $query =  $this->consulta($id);
            return response()->json($query, 201);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {

        try {
            $this->valdacionupdate($request, $id);
            try {
                $sql = DB::table('users')->where("id", "=", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "documento" => $request->documento,
                    "direccion" => $request->direccion,
                    "updated_at" => Carbon::now(),
                ]);
                if ($sql) {
                    return response()->json(["message" => "Se ha registrado con éxito."], 201);
                }
            } catch (QueryException $th) {
                return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
            }
        } catch (ValidationException $exception) {
            return response()->json(["message" => "Error de validación verifique los datos nuevamente .", "errors" => $exception], 422);
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

        try {
            $query =  $this->consulta($id);
            if (count($query) > 0) {
                $sql = DB::table('users')->where("id", "=", $id)->delete();
                if ($sql) {
                    return response()->json(["message" => "Se ha registrado con éxito."], 201);
                }
            }
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
}
