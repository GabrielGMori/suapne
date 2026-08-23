<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanoFlexibilizacaoController;

Route::resourceVerbs([
    'edit' => 'editar'
]);

Route::view('/temp', 'components-temp');

Route::redirect('/', '/dashboard');

Route::middleware('web')->group(base_path('routes/auth.php'));

// Grupo de rotas autenticadas
Route::middleware('auth')->group(function () {

    Route::view('/dashboard', 'dashboard.index')->name('dashboard.index');
    Route::middleware('web')->group(base_path('routes/estudantes.php'));
    
    // Rotas do Plano de Flexibilização
    Route::middleware('web')->group(base_path('routes/planos-flexibilizacao.php'));
    Route::get('/planos-flexibilizacao/{id}/pdf', [PlanoFlexibilizacaoController::class, 'exportPdf'])
        ->name('planos-flexibilizacao.pdf');

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

});