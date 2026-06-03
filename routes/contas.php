<?php

Route::name('contas.')->prefix('contas')->group(function () {
    Route::name('cnapne.')->prefix('cnapne')->group(function () {
        Route::view('/', 'contas.cnapne.index')->name('index');
        Route::view('/editar', 'contas.cnapne.form')->name('form');
    });

    Route::name('professor.')->prefix('professor')->group(function () {
        Route::view('/', 'contas.professor.index')->name('index');
        Route::view('/editar', 'contas.professor.form')->name('form');
    });
});
