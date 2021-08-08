<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Events\Notificacion;
use App\Http\Controllers\Apicontroller\RolesPermisosController;
use App\Http\Controllers\rolesController;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public  $menu = '';
    public function __construct()
    {
        $this->menu = new rolesController();
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function  login(Request $request)
    {
        //  $credentials = request(['email', 'password']);
        $datba  = User::with("roles")->where('email', $request->email)->first();
        if (empty($datba)) {
            return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.'], 401);
        }
        $credentials = $request->only('email', 'password');
        // $credentials = $request->only('email', 'password');

        foreach ($datba->roles as $query) {
            if ($query->rname == "administrador") {
                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }
            }
            if ($query->rname == "vendedor") {
                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token);
                }
            }
        }
        return response()->json(['message' => 'Usuario o contraseña incorrectos. Por favor, verifique la información.'], 401);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */


    protected function respondWithToken($token)
    {
        $menu = $this->menu->rutaprincipales();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            "users" => Auth()->user(),
            'menu' => $menu
        ]);
    }
    public function guard()
    {
        return Auth::guard();
    }
}
