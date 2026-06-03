<?php

Route::name('cursos.')->prefix('cursos')->group(function () {
    Route::view('/', 'cursos.index')->name('index');
    Route::view('/novo', 'cursos.form')->name('form');
    Route::get("/{id}/editar", fn(int $id) => view("cursos.form", ['curso' => App\Models\Curso::findOrFail($id)]))->name('edit');
});
