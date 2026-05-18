<?php

use App\Models\Estudante;
use Illuminate\Support\Facades\Route;

Route::view('/components-temp', 'components-temp')->name('components-temp');
Route::view('/temp', 'temp')->name('temp');

Route::redirect('/', '/login');

Route::view('/login', 'auth.login')->name('auth.login');

Route::name('auth.cadastro.')->prefix('cadastro')->group(function () {
    Route::view('/', 'auth.cadastro.escolher')->name('index');
    Route::view('/professor', 'auth.cadastro.professor-regular')->name('professor');
    Route::view('/docente', 'auth.cadastro.docente-especial')->name('docente');
    Route::view('/tecnico', 'auth.cadastro.tecnico')->name('tecnico');
    Route::view('/enviado', 'auth.cadastro.enviado')->name('enviado');
});

Route::view('/dashboard', 'dashboard.index')->name('dashboard.index');

Route::name('estudantes.')->prefix('estudantes')->group(function () {
    Route::view('/', 'estudantes.index')->name('index');
    Route::view('/form', 'estudantes.form')->name('form');
    Route::get("/{id}/visualizar", 
        fn(int $id) => view("estudantes.show", ['estudante' => Estudante::findOrFail($id)]))->name('show');
    Route::view("/adicionar-documento", 'estudantes.add-documento')->name('add-documento');
});

Route::name('atendimentos.')->prefix('atendimentos')->group(function () {
    Route::view('/', 'atendimentos.index')->name('index');
    Route::view('/novo', 'atendimentos.form')->name('form');
    Route::view('/visualizar', 'atendimentos.show')->name('show');
});

Route::prefix('contas')->group(function () {
    Route::name('contas.cnapne.')->prefix('cnapne')->group(function () {
        Route::view('/', 'contas.cnapne.index')->name('index');
        Route::view('/editar', 'contas.cnapne.editar')->name('editar');
    });

    Route::name('contas.professor.')->prefix('professor')->group(function () {
        Route::view('/', 'contas.professor.index')->name('index');
        Route::view('/editar', 'contas.professor.editar')->name('editar');
    });

    Route::view('/contasprofessor', 'contas.professor.editar');
});

Route::name('cursos.')->prefix('cursos')->group(function () {
    Route::view('/', 'cursos.index')->name('index');
    Route::view('/novo', 'cursos.form')->name('form');
    Route::view('/curso', 'cursos.form');
});

Route::name('disciplinas.')->prefix('disciplinas')->group(function () {
    Route::view('/', 'disciplinas.index')->name('index');
    Route::view('/novo', 'disciplinas.form')->name('form');
    Route::view('/disciplina', 'disciplinas.form');
});

Route::name('entrevistas-familiares.')->prefix('entrevistas-familiares')->group(function () {
    Route::view('/', 'entrevistas-familiares.index')->name('index');
    Route::view('/novo', 'entrevistas-familiares.create')->name('create');
});

Route::name('planos-flexibilizacao.')->prefix('planos-flexibilizacao')->group(function () {
    Route::view('/', 'planos-flexibilizacao.index')->name('index');
    Route::view('/novo', 'planos-flexibilizacao.form')->name('form');
    Route::view('/visualizar', 'planos-flexibilizacao.show')->name('show');
});

Route::name('planos-trabalho.')->prefix('planos-trabalho')->group(function () {
    Route::view('/', 'planos-trabalho.index')->name('index');
    Route::view('/novo', 'planos-trabalho.form')->name('form');
    Route::view('/preenchimento', 'planos-trabalho.preenchimento')->name('preenchimento');
    Route::view('/previsualizacao', 'planos-trabalho.previsualizacao')->name('previsualizacao');
    Route::view('/revisao', 'planos-trabalho.revisao')->name('revisao');
    Route::view('/visualizar', 'planos-trabalho.show')->name('show');
});

Route::name('registro-auditoria.')->group(function () {
    Route::view('/registro-auditoria', 'registro-auditoria.index')->name('index');
});

Route::name('solicitacoes-registro.')->group(function () {
    Route::view('/solicitacoes-registro', 'solicitacoes-registro.index')->name('index');
});
