<?php

Route::name('planos-trabalho.')->prefix('planos-trabalho')->group(function () {
    Route::view('/', 'planos-trabalho.index')->name('index');
    Route::view('/novo', 'planos-trabalho.form')->name('form');
    Route::view('/preenchimento', 'planos-trabalho.preenchimento')->name('preenchimento');
    Route::view('/previsualizacao', 'planos-trabalho.previsualizacao')->name('previsualizacao');
    Route::view('/revisao', 'planos-trabalho.revisao')->name('revisao');
    Route::get('/{id}/visualizar', static fn(int $id) => view("planos-trabalho.show", ['plano-trabalho' => App\Models\PlanoTrabalhoEstudante::find($id)]))->name('show');
    
});
