<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::controller(LoginController::class)->group(function () {
    Route::middleware('guest')->get('/login', 'index')->name('login.index');
    Route::middleware('guest')->post('/login', 'login')->name('login');
    Route::middleware('auth')->post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->name('cadastro.')->prefix('cadastro')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::view('/', 'auth.cadastro.escolher')->name('index');
        Route::view('/professor', 'auth.cadastro.professor-regular')->name('professor');
        Route::view('/tecnico', 'auth.cadastro.cnapne', ['role' => 'TECNICO'])->name('tecnico');
        Route::view('/docente', 'auth.cadastro.cnapne', ['role' => 'DOCENTE_ESPECIAL'])->name('docente');
        Route::view('/enviado', 'auth.cadastro.enviado')->name('enviado');
        Route::post('/', 'submit')->name('submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/aceitar/{solicitacao}', 'accept')->name('accept');
        Route::post('/recusar/{solicitacao}', 'decline')->name('decline');
    });
});
