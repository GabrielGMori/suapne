<?php

use App\Http\Controllers\PlanoTrabalhoEstudanteController;

Route::controller(PlanoTrabalhoEstudanteController::class)->name('planos-trabalho.')->prefix('/planos-trabalho')->group(function () {
    Route::post('/preview', 'preview')->name('preview');
    Route::post('/preview/change', 'changePreview')->name('change-preview');
    Route::get('/novo/{estudante?}', 'create')->name('create');
    Route::get('/{planoTrabalho}/exportar', 'exportPdf')->name('export-pdf');
});

Route::resource('planos-trabalho', PlanoTrabalhoEstudanteController::class)->except('create')->parameter('planos-trabalho', 'plano-trabalho');
