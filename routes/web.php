<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\PlanoFlexibilizacaoCurricularController;
use App\Mail\PlanoTrabalhoDevolvido;
use App\Mail\VerificarEmail;
use Illuminate\Support\Facades\Route;

Route::resourceVerbs([
    'create' => 'novo',
    'edit' => 'editar',
]);

Route::redirect('/', '/dashboard');

Route::middleware('web')->group(base_path('routes/auth.php'));

Route::middleware('auth')->group(function () {

    Route::view('/dashboard', 'dashboard.index')->name('dashboard.index');

    Route::middleware('web')->group(base_path('routes/estudantes.php'));

    Route::middleware('web')->group(base_path('routes/planos-flexibilizacao.php'));

    Route::get('/planos-flexibilizacao/{id}/pdf',
        [PlanoFlexibilizacaoCurricularController::class, 'exportPdf']
    )->name('planos-flexibilizacao.pdf');

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

// Route::get('/mailable', function () {
//     $code = '748375';

//     return new App\Mail\VerificarEmail('jorge', $code);
// });

// Route::view('/temp', 'components-temp');
