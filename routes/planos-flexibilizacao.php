<?php

Route::name('planos-flexibilizacao.')->prefix('planos-flexibilizacao')->group(function () {
    Route::view('/', 'planos-flexibilizacao.index')->name('index');
    Route::view('/novo', 'planos-flexibilizacao.form')->name('form');
    Route::get('/{id}/visualizar', static fn(int $id) => view("planos-flexibilizacao.show", ['plano-flexibilizacao' => App\Models\PlanoFlexibilizacaoCurricular::find($id)]))->name('show');
});
