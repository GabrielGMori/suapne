<?php

use App\Http\Controllers\PlanoFlexibilizacaoCurricularController;

Route::controller(PlanoFlexibilizacaoCurricularController::class)->name('planos-flexibilizacao.')->prefix('/planos-flexibilizacao')->group(function () {
    Route::get('/novo/{estudante?}', 'create')->name('create');
    Route::get('/{planoFlexibilizacao}/exportar-pdf', 'exportPdf')->name('exportPdf');
    Route::post('/{planoFlexibilizacao}/restaurar', 'restore')->withTrashed()->name('restore');
});

Route::resource('planos-flexibilizacao', PlanoFlexibilizacaoCurricularController::class)->parameter('planos-flexibilizacao', 'planoFlexibilizacao')->except('create');
