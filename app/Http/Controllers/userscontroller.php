<?php

namespace App\Http\Controllers;

use App\Http\Repository\Usuariorepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;
use App\User;

class userscontroller extends Controller
{
    public $repositorio;
    public function __construct()
    {
        $this->middleware(['apijwt', 'auth:api']);
        $this->repositorio =  new Usuariorepository();
    }

    public function index()
    {

        Gate::authorize('rutapermiso', [["userslistar"]]);
        try {
            return  $this->repositorio->index();
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }

    public function  create()
    {
        Gate::authorize('rutapermiso', [["usersguardar"]]);
    }

    public function store(Request $request)
    {
        Gate::authorize('rutapermiso', [["usersguardar"]]);
        try {
            return  $this->repositorio->store($request);
        } catch (ValidationException $exception) {
            return response()->json(["message" => "Error de validación verifique los datos nuevamente .", "errors" => $exception], 422);
        }
    }

    public function  show($id)
    {

        try {
            if ($id == auth()->user()->id) {
                return $this->repositorio->show($id);
            }
            Gate::authorize('rutapermiso', [["usersver"]]);
            return  $this->repositorio->show($id);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function  edit($id)
    {

        try {
            if ($id == auth()->user()->id) {
                return $this->repositorio->show($id);
            }
            Gate::authorize('rutapermiso', [["usersver"]]);
            return  $this->repositorio->edit($id);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function  update(Request $request, $id)
    {

        try {
            if ($id == auth()->user()->id) {
                return $this->repositorio->update($request, $id);
            }
            Gate::authorize('rutapermiso', [["usersactualizar"]]);
            return   $this->repositorio->update($request, $id);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
    public function  destroy($id)
    {
        Gate::authorize('rutapermiso', [["userseliminar"]]);
        try {
            return   $this->repositorio->destroy($id);
        } catch (QueryException $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
}
