<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/apiIVision')->group(function () {

    Route::post('/usuario/criar',  'UsuariosController@cadastrarUsuario');
    Route::post('/usuario/editar',  'UsuariosController@editarUsuario');
    Route::post('/login',  'UsuariosController@login');
    Route::post('/atividade/criar',  'AtividadesController@cadastrarAtividade');
    Route::get('/atividade/listar',  'AtividadesController@editarAtividade');
    Route::post('/atividade/editar',  'AtividadesController@apagarAtividade');
});

Route::get('/', function () {
    return view('welcome');
});
