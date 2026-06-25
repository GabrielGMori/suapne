<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::controller(LoginController::class)->group(function () {
    Route::middleware('guest')->get('/login', 'index')->name('login.index');
    Route::middleware('guest')->post('/login', 'login')->name('login');
    Route::middleware('auth')->post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->name('cadastro.')->prefix('cadastro')->group(function () {
    Route::view('/', 'auth.cadastro.escolher')->name('index');
    Route::view('/professor', 'auth.cadastro.professor-regular')->name('professor');
    Route::view('/docente', 'auth.cadastro.docente-especial')->name('docente');
    Route::view('/tecnico', 'auth.cadastro.tecnico')->name('tecnico');
    Route::view('/enviado', 'auth.cadastro.enviado')->name('enviado');
});
