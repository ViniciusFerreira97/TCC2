<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/usuario/criar',  'UsuariosController@cadastrarUsuario');
Route::post('/usuario/editar',  'UsuariosController@editarUsuario');
Route::post('/login',  'UsuariosController@login');
Route::post('/atividade/criar',  'AtividadesController@cadastrarAtividade');
Route::get('/atividade/listar',  'AtividadesController@editarAtividade');
Route::post('/atividade/editar',  'AtividadesController@apagarAtividade');
