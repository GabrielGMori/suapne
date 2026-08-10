<?php

use App\Http\Controllers\DisciplinaController;

Route::name('disciplinas.')->prefix('disciplinas')->group(function () {
    Route::get('/', [DisciplinaController::class, 'index'])->name('index');
    Route::view('/novo', 'disciplinas.form')->name('form');
    Route::get('/{id}/editar', [DisciplinaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DisciplinaController::class, 'update'])->name('update');
    Route::post('/', [DisciplinaController::class, 'store'])->name('store');
    Route::delete('/{id}', [DisciplinaController::class, 'destroy'])->name('destroy');
});
