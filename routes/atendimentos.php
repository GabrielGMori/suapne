<?php

use App\Http\Controllers\AtendimentoSemanalController;
use Illuminate\Support\Facades\Route;

Route::controller(AtendimentoSemanalController::class)->name('atendimentos.')->prefix('/atendimentos')->group(function () {
    Route::get('/novo/{estudante?}', 'create')->name('create');
});

Route::resource('atendimentos',AtendimentoSemanalController::class)->except('create');
