<?php

use Illuminate\Support\Facades\Route;

Route::name('estudantes.')->prefix('estudantes')->group(function () {
    Route::view('/', 'estudantes.index')->name('index');
    Route::view('/form', 'estudantes.form')->name('form');
    Route::get("/{id}/visualizar", static fn($id) => view("estudantes.show", ['estudante' => App\Models\Estudante::findOrFail($id)]))->name('show');

    Route::name('documentos.')->prefix("/{id}/documentos")->group(function () {
        Route::get("/adicionar", static fn($id) => view('estudantes.add-documento', ['estudante' => App\Models\Estudante::findOrFail($id)]))->name('add');
    });

    Route::name('entrevistas-familiares.')->prefix('/entrevista-familiar')->group(function () {
        Route::view('/novo', 'entrevistas-familiares.form')->name('form');
        Route::get("/{id}/visualizar", static fn($id) => view('entrevistas-familiares.show', ['entrevistaFamiliar' => App\Models\EntrevistaFamiliar::findOrFail($id)]))->name('show');
    });
});
