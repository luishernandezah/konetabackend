<?php

namespace App\Http\Controllers;

use App\Http\Repository\Clienterepository;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class clientsController extends Controller
{
    private $id = 3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $repositorio;

    public function __construct()
    {

        $this->middleware(['apijwt', 'auth:api']);
        $this->repositorio  = new Clienterepository();
    }



    public function index()
    {
        Gate::authorize('rutapermiso', [["clientelistar"]]);

        try {
            return  $this->repositorio->index();
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
        Gate::authorize('rutapermiso', [["clienteguardar"]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('rutapermiso', [["clienteguardar"]]);
        try {
            return  $this->repositorio->show($request);
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
        Gate::authorize('rutapermiso', [["clientever"]]);
        try {

            return  $this->repositorio->show($id);
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
            Gate::authorize('rutapermiso', [["clienteactualizar"]]);

            return  $this->repositorio->edit($id);
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
    public function update(Request $request, $id)
    {
        Gate::authorize('rutapermiso', [["clienteactualizar"]]);
        try {
            return  $this->repositorio->update($request, $id);
        } catch (Exception $th) {
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
        Gate::authorize('rutapermiso', [["clienteeliminar"]]);
        try {
            return  $this->repositorio->destroy($id);
        } catch (Exception $th) {
            return response()->json(["message" => "Error interno servidor", "errors" => $th], 500);
        }
    }
}
