<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('contas')->name('contas.')->group(function () {

    // Contas CNAPNE
    Route::prefix('cnapne')->name('cnapne.')->group(function () {
        Route::get('/', [UserController::class, 'indexCnapne'])->name('index');
        Route::get('/{user}/editar', [UserController::class, 'editCnapne'])->name('edit');
        Route::patch('/{user}', [UserController::class, 'updateCnapne'])->name('update');
    });

    // Contas de Professores
    Route::prefix('professor')->name('professor.')->group(function () {
        Route::get('/', [UserController::class, 'indexProfessor'])->name('index');
        Route::get('/{user}/editar', [UserController::class, 'editProfessor'])->name('edit');
        Route::patch('/{user}', [UserController::class, 'updateProfessor'])->name('update');
    });

});