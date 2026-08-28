<?php

use App\Http\Controllers\PlanoFlexibilizacaoCurricularController;

Route::controller(PlanoFlexibilizacaoCurricularController::class)->name('planos-flexibilizacao.')->prefix('/planos-flexibilizacao')->group(function () {
    Route::get('/novo/{estudante?}', 'create')->name('create');
});

Route::resource('planos-flexibilizacao', PlanoFlexibilizacaoCurricularController::class)->parameter('planos-flexibilizacao', 'plano-flexibilizacao')->except('create');
