<?php

Route::redirect('/', '/login');

Route::view('/login', 'auth.login')->name('auth.login');

Route::name('auth.cadastro.')->prefix('cadastro')->group(function () {
    Route::view('/', 'auth.cadastro.escolher')->name('index');
    Route::view('/professor', 'auth.cadastro.professor-regular')->name('professor');
    Route::view('/docente', 'auth.cadastro.docente-especial')->name('docente');
    Route::view('/tecnico', 'auth.cadastro.tecnico')->name('tecnico');
    Route::view('/enviado', 'auth.cadastro.enviado')->name('enviado');
});
