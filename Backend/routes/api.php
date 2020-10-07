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

Route::post('/login',  'Auth\UsuariosController@login');
Route::post('/usuario/criar',  'Auth\UsuariosController@cadastrarUsuario');
Route::post('/usuario/criar',  'Auth\UsuariosController@cadastrarUsuario');
Route::post('/usuario/editar',  'Auth\UsuariosController@editarUsuario');
Route::post('/atividade/criar',  'AtividadesController@cadastrarAtividade');
Route::get('/atividade/listar/{codigoAtividade}',  'AtividadesController@listarAtividades');
Route::post('/atividade/editar',  'AtividadesController@apagarAtividade');
Route::post('/atividade/editar',  'AtividadesController@apagarAtividade');
Route::get('/dados/questao/listar/{codigoQuestao}',  'AtividadesController@listarDadosQuestao');
Route::post('/atividade/questao/criar',  'AtividadesController@cadastrarQuestao');
