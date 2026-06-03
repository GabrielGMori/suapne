<?php

Route::name('atendimentos.')->prefix('atendimentos')->group(function () {
    Route::view('/', 'atendimentos.index')->name('index');
    Route::view('/novo', 'atendimentos.form')->name('form');
    Route::get('/{id}/visualizar', static fn(int $id) => view("atendimentos.show", ['atendimento' => \App\Models\AtendimentoSemanal::find($id)]))->name('show');
});
