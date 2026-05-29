<?php

use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\EntrevistaFamiliar;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\PlanoTrabalhoEstudante;
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
    Route::get("/{id}/visualizar", static fn(int $id) => view("estudantes.show", ['estudante' => Estudante::find($id)]))->name('show');

    Route::name('documentos.')->prefix('documentos')->group(function () {
        Route::view("/adicionar", 'estudantes.add-documento')->name('add');
    });

    Route::name('entrevistas-familiares.')->prefix('/entrevista-familiar')->group(function () {
        Route::view('/novo', 'entrevistas-familiares.form')->name('form');
        Route::get('/{id}/visualizar', static fn(int $id) => view('entrevistas-familiares.show', ['entrevista-familiar' => EntrevistaFamiliar::find($id)]))->name('show');
    });
});

Route::name('planos-flexibilizacao.')->prefix('planos-flexibilizacao')->group(function () {
    Route::view('/', 'planos-flexibilizacao.index')->name('index');
    Route::view('/novo', 'planos-flexibilizacao.form')->name('form');
    Route::get('/{id}/visualizar', static fn(int $id) => view("planos-flexibilizacao.show", ['plano-flexibilizacao' => PlanoFlexibilizacaoCurricular::find($id)]))->name('show');
});

Route::name('planos-trabalho.')->prefix('planos-trabalho')->group(function () {
    Route::view('/', 'planos-trabalho.index')->name('index');
    Route::view('/novo', 'planos-trabalho.form')->name('form');
    Route::view('/preenchimento', 'planos-trabalho.preenchimento')->name('preenchimento');
    Route::view('/previsualizacao', 'planos-trabalho.previsualizacao')->name('previsualizacao');
    Route::view('/revisao', 'planos-trabalho.revisao')->name('revisao');
    Route::get('/{id}/visualizar', static fn(int $id) => view("planos-trabalho.show", ['plano-trabalho' => PlanoTrabalhoEstudante::find($id)]))->name('show');
});

Route::name('atendimentos.')->prefix('atendimentos')->group(function () {
    Route::view('/', 'atendimentos.index')->name('index');
    Route::view('/novo', 'atendimentos.form')->name('form');
    Route::get('/{id}/visualizar', static fn(int $id) => view("atendimentos.show", ['atendimento' => \App\Models\AtendimentoSemanal::find($id)]))->name('show');
});

Route::name('registro-auditoria.')->group(function () {
    Route::view('/registro-auditoria', 'registro-auditoria.index')->name('index');
});

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

Route::name('solicitacoes-registro.')->group(function () {
    Route::view('/solicitacoes-registro', 'solicitacoes-registro.index')->name('index');
});

Route::name('cursos.')->prefix('cursos')->group(function () {
    Route::view('/', 'cursos.index')->name('index');
    Route::view('/novo', 'cursos.form')->name('form');
    Route::get("/{id}/editar", fn(int $id) => view("cursos.form", ['curso' => Curso::findOrFail($id)]))->name('edit');
});

Route::name('disciplinas.')->prefix('disciplinas')->group(function () {
    Route::view('/', 'disciplinas.index')->name('index');
    Route::view('/novo', 'disciplinas.form')->name('form');
    Route::get('/{id}/editar', fn(int $id) => view("disciplinas.form", ['disciplina' => Disciplina::findOrFail($id)]))->name('edit');
});
