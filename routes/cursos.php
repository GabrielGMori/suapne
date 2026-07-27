<?php

use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::resource('cursos', CursoController::class)->except('show');
