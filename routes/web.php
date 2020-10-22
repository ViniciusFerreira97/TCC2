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


Route::get('/', function () {
    return view('login');
});

Route::get('/aluno', function () {
    return view('Aluno.homeAluno');
});

Route::get('/professor', function () {
    return view('Professor.homeProfessor');
});

Route::get('/login', function () {
    return view('login');
});
