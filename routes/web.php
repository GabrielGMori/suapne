<?php

use Illuminate\Support\Facades\Route;

// Route::view('/components-temp', 'components-temp')->name('components-temp');

Route::middleware('guest')->group(base_path('routes/auth.php'));

Route::view('/dashboard', 'dashboard.index')->name('dashboard.index');
Route::middleware('web')->group(base_path('routes/estudantes.php'));
Route::middleware('web')->group(base_path('routes/planos-flexibilizacao.php'));
Route::middleware('web')->group(base_path('routes/planos-trabalho.php'));
Route::middleware('web')->group(base_path('routes/atendimentos.php'));

Route::middleware('web')->group(base_path('routes/contas.php'));

Route::name('registro-auditoria.')->group(function () {
    Route::view('/registro-auditoria', 'registro-auditoria.index')->name('index');
});

Route::name('solicitacoes-registro.')->group(function () {
    Route::view('/solicitacoes-registro', 'solicitacoes-registro.index')->name('index');
});

Route::middleware('web')->group(base_path('routes/cursos.php'));
Route::middleware('web')->group(base_path('routes/disciplinas.php'));
