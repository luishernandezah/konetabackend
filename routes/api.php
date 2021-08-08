<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/hola', function () {
});

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'Api\AuthController@login')->middleware('api');
Route::group([
    'middleware' => ['apijwt', 'api', 'auth']
], function () {
    Route::post('logout', 'Api\AuthController@logout');
});

Route::group([
    'middleware' => ['apijwt', 'api', 'auth']
], function () {
    Route::resource('clients', 'clientsController');
    Route::resource('users', 'userscontroller');
    Route::resource('roles', 'rolesController');
});
