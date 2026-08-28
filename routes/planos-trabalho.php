<?php

use App\Http\Controllers\PlanoTrabalhoEstudanteController;

Route::controller(PlanoTrabalhoEstudanteController::class)->name('planos-trabalho.')->prefix('/planos-trabalho')->group(function () {
    Route::get('/preview', 'preview')->name('preview');
    Route::get('/novo/{estudante?}', 'create')->name('create');
});

Route::resource('planos-trabalho', PlanoTrabalhoEstudanteController::class)->except('create')->parameter('planos-trabalho', 'plano-trabalho');
