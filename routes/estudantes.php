<?php

use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EstudanteController;
use App\Http\Controllers\ObservacaoEstudanteController;
use Illuminate\Support\Facades\Route;

Route::resource('estudantes', EstudanteController::class);

Route::name('estudantes.')->prefix('estudantes')->group(function () {
    Route::controller(EstudanteController::class)->group(function () {
        Route::post('/{estudante}/restaurar', 'restore')->withTrashed()->name('restore');
    });

    Route::controller(ObservacaoEstudanteController::class)->name('observacoes.')->group(function () {
        Route::post('/{estudante}/observacoes', 'store')->name('store');
        Route::delete('/observacoes/{observacaoEstudante}', 'destroy')->name('destroy');
    });

    Route::controller(DocumentoController::class)->name('documentos.')->prefix("/{id}/documentos")->group(function () {
        Route::get("/adicionar", static fn($id) => view('estudantes.create-documento', ['estudante' => App\Models\Estudante::findOrFail($id)]))->name('create');
    });

    Route::name('entrevistas-familiares.')->prefix('/entrevista-familiar')->group(function () {
        Route::view('/novo', 'entrevistas-familiares.form')->name('form');
        Route::get("/{id}/visualizar", static fn($id) => view('entrevistas-familiares.show', ['entrevistaFamiliar' => App\Models\EntrevistaFamiliar::findOrFail($id)]))->name('show');
    });
});
