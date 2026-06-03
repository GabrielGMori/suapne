<?php

Route::name('disciplinas.')->prefix('disciplinas')->group(function () {
    Route::view('/', 'disciplinas.index')->name('index');
    Route::view('/novo', 'disciplinas.form')->name('form');
    Route::get('/{id}/editar', fn(int $id) => view("disciplinas.form", ['disciplina' => App\Models\Disciplina::findOrFail($id)]))->name('edit');
});
