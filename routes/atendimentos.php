<?php

use App\Http\Controllers\AtendimentoSemanalController;
use Illuminate\Support\Facades\Route;

Route::resource('atendimentos',AtendimentoSemanalController::class);
