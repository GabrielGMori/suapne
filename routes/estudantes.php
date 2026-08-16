<?php

use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EntrevistaFamiliarController;
use App\Http\Controllers\EstudanteController;
use App\Http\Controllers\ObservacaoEstudanteController;
use Illuminate\Support\Facades\Route;

Route::resource('estudantes', EstudanteController::class);

Route::name('estudantes.')->prefix('/estudantes/{estudante}')->group(function () {
    Route::controller(EstudanteController::class)->group(function () {
        Route::post('/restaurar', 'restore')->withTrashed()->name('restore');
    });

    Route::controller(ObservacaoEstudanteController::class)->name('observacoes.')->group(function () {
        Route::post('/observacoes', 'store')->name('store');
        Route::delete('/observacoes/{observacaoEstudante}', 'destroy')->name('destroy');
    });

    Route::controller(EntrevistaFamiliarController::class)->name('entrevistas-familiares.')->prefix("/entrevistas-familiares")->group(function () {
        Route::get('/novo', 'create')->name('create');
        Route::get("/{entrevistaFamiliar}/visualizar", 'show')->name('show');
    });

    Route::controller(DocumentoController::class)->name('documentos.')->prefix("/documentos")->group(function () {
        Route::get("/adicionar", 'create')->name('create');
    });
});
