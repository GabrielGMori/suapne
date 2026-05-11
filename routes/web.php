<?php

use Illuminate\Support\Facades\Route;

Route::view('/temp', 'components-temp');
Route::view('/', 'temp');
Route::view ('/iniciar', 'dashboard/index');
Route::view('/curso','cursos/form');
Route::view('/disciplina','disciplinas/form');
Route::view('/contasprofessor','contas/professor/editar');

