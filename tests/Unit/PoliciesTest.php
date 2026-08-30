<?php

use App\Enums\RoleEnum;
use App\Models\AtendimentoSemanal;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Documento;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\SolicitacaoRegistro;
use App\Models\User;
use App\Policies\AtendimentoSemanalPolicy;
use App\Policies\AuditPolicy;
use App\Policies\CursoPolicy;
use App\Policies\DisciplinaPolicy;
use App\Policies\DocumentoPolicy;
use App\Policies\EntrevistaFamiliarPolicy;
use App\Policies\EstudantePolicy;
use App\Policies\ObservacaoEstudantePolicy;
use App\Policies\PlanoFlexibilizacaoCurricularPolicy;
use App\Policies\PlanoTrabalhoEstudantePolicy;
use App\Policies\SolicitacaoRegistroPolicy;
use App\Policies\UserPolicy;

beforeEach(function () {
    $this->docenteEspecial = new User(['id' => 1, 'role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = new User(['id' => 2, 'role' => RoleEnum::TECNICO]);
    $this->professor = new User(['id' => 3, 'role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('AuditPolicy allows DOCENTE_ESPECIAL and restricts others', function () {
    $policy = new AuditPolicy();

    expect($this->docenteEspecial->can('viewAny', \OwenIt\Auditing\Models\Audit::class))->toBeTrue()
        ->and($this->tecnico->can('viewAny', \OwenIt\Auditing\Models\Audit::class))->toBeFalse()
        ->and($this->professor->can('viewAny', \OwenIt\Auditing\Models\Audit::class))->toBeFalse();
});

test('CursoPolicy permissions across roles', function () {
    $curso = new Curso(['id' => 10]);

    expect($this->docenteEspecial->can('viewAny', Curso::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', Curso::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $curso))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $curso))->toBeTrue()
        ->and($this->tecnico->can('viewAny', Curso::class))->toBeFalse()
        ->and($this->tecnico->can('create', Curso::class))->toBeFalse()
        ->and($this->professor->can('viewAny', Curso::class))->toBeFalse();
});

test('DisciplinaPolicy permissions across roles', function () {
    $disciplina = new Disciplina(['id' => 20]);

    expect($this->docenteEspecial->can('viewAny', Disciplina::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', Disciplina::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $disciplina))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $disciplina))->toBeTrue()
        ->and($this->tecnico->can('viewAny', Disciplina::class))->toBeFalse()
        ->and($this->professor->can('viewAny', Disciplina::class))->toBeFalse();
});

test('DocumentoPolicy permissions across roles', function () {
    $documento = new Documento(['id' => 30]);

    expect($this->docenteEspecial->can('create', Documento::class))->toBeTrue()
        ->and($this->tecnico->can('create', Documento::class))->toBeFalse()
        ->and($this->professor->can('create', Documento::class))->toBeFalse();
});

test('EntrevistaFamiliarPolicy permissions across roles', function () {
    $entrevista = new EntrevistaFamiliar(['id' => 40]);

    expect($this->docenteEspecial->can('viewAny', EntrevistaFamiliar::class))->toBeTrue()
        ->and($this->docenteEspecial->can('view', $entrevista))->toBeTrue()
        ->and($this->docenteEspecial->can('create', EntrevistaFamiliar::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $entrevista))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $entrevista))->toBeTrue()
        ->and($this->tecnico->can('viewAny', EntrevistaFamiliar::class))->toBeFalse();
});

test('EstudantePolicy permissions across roles', function () {
    $estudante = new Estudante(['id' => 50]);

    expect($this->docenteEspecial->can('viewAny', Estudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('view', $estudante))->toBeTrue()
        ->and($this->docenteEspecial->can('create', Estudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $estudante))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $estudante))->toBeTrue()
        ->and($this->docenteEspecial->can('restore', $estudante))->toBeTrue()
        ->and($this->tecnico->can('viewAny', Estudante::class))->toBeTrue()
        ->and($this->tecnico->can('view', $estudante))->toBeTrue()
        ->and($this->tecnico->can('create', Estudante::class))->toBeTrue()
        ->and($this->tecnico->can('update', $estudante))->toBeTrue()
        ->and($this->tecnico->can('delete', $estudante))->toBeFalse()
        ->and($this->tecnico->can('restore', $estudante))->toBeFalse()
        ->and($this->professor->can('viewAny', Estudante::class))->toBeTrue()
        ->and($this->professor->can('create', Estudante::class))->toBeFalse();
});

test('ObservacaoEstudantePolicy permissions across roles', function () {
    $obsOwn = new ObservacaoEstudante(['id' => 60, 'user_id' => $this->tecnico->id]);
    $obsOther = new ObservacaoEstudante(['id' => 61, 'user_id' => 999]);

    expect($this->docenteEspecial->can('viewAny', ObservacaoEstudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', ObservacaoEstudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $obsOther))->toBeTrue()
        ->and($this->tecnico->can('create', ObservacaoEstudante::class))->toBeTrue()
        ->and($this->tecnico->can('delete', $obsOwn))->toBeTrue()
        ->and($this->tecnico->can('delete', $obsOther))->toBeFalse();
});

test('AtendimentoSemanalPolicy permissions across roles', function () {
    $atendimentoOwn = new AtendimentoSemanal(['id' => 70, 'user_id' => $this->tecnico->id]);
    $atendimentoOther = new AtendimentoSemanal(['id' => 71, 'user_id' => 999]);

    expect($this->docenteEspecial->can('viewAny', AtendimentoSemanal::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', AtendimentoSemanal::class))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $atendimentoOther))->toBeTrue()
        ->and($this->tecnico->can('viewAny', AtendimentoSemanal::class))->toBeTrue()
        ->and($this->tecnico->can('create', AtendimentoSemanal::class))->toBeTrue()
        ->and($this->tecnico->can('view', $atendimentoOwn))->toBeTrue()
        ->and($this->tecnico->can('view', $atendimentoOther))->toBeFalse()
        ->and($this->tecnico->can('update', $atendimentoOwn))->toBeFalse()
        ->and($this->professor->can('viewAny', AtendimentoSemanal::class))->toBeFalse();
});

test('PlanoFlexibilizacaoCurricularPolicy permissions across roles', function () {
    $planoOwn = new PlanoFlexibilizacaoCurricular(['id' => 80, 'user_id' => $this->tecnico->id]);
    $planoOther = new PlanoFlexibilizacaoCurricular(['id' => 81, 'user_id' => 999]);

    expect($this->docenteEspecial->can('viewAny', PlanoFlexibilizacaoCurricular::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', PlanoFlexibilizacaoCurricular::class))->toBeTrue()
        ->and($this->tecnico->can('viewAny', PlanoFlexibilizacaoCurricular::class))->toBeTrue()
        ->and($this->tecnico->can('create', PlanoFlexibilizacaoCurricular::class))->toBeTrue()
        ->and($this->tecnico->can('view', $planoOther))->toBeTrue()
        ->and($this->tecnico->can('update', $planoOwn))->toBeTrue()
        ->and($this->tecnico->can('update', $planoOther))->toBeFalse()
        ->and($this->professor->can('viewAny', PlanoFlexibilizacaoCurricular::class))->toBeFalse();
});

test('PlanoTrabalhoEstudantePolicy permissions across roles', function () {
    $planoProf = new PlanoTrabalhoEstudante(['id' => 90, 'user_id' => 10, 'user_professor_id' => $this->professor->id]);
    $planoOther = new PlanoTrabalhoEstudante(['id' => 91, 'user_id' => 10, 'user_professor_id' => 999]);

    expect($this->docenteEspecial->can('viewAny', PlanoTrabalhoEstudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('create', PlanoTrabalhoEstudante::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $planoOther))->toBeTrue()
        ->and($this->tecnico->can('viewAny', PlanoTrabalhoEstudante::class))->toBeTrue()
        ->and($this->tecnico->can('create', PlanoTrabalhoEstudante::class))->toBeTrue()
        ->and($this->tecnico->can('view', $planoOther))->toBeTrue()
        ->and($this->professor->can('view', $planoProf))->toBeTrue()
        ->and($this->professor->can('view', $planoOther))->toBeFalse()
        ->and($this->professor->can('update', $planoProf))->toBeTrue()
        ->and($this->professor->can('update', $planoOther))->toBeFalse();
});

test('SolicitacaoRegistroPolicy permissions across roles', function () {
    $solicitacao = new SolicitacaoRegistro(['id' => 100]);

    expect($this->docenteEspecial->can('viewAny', SolicitacaoRegistro::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $solicitacao))->toBeTrue()
        ->and($this->docenteEspecial->can('delete', $solicitacao))->toBeTrue()
        ->and($this->tecnico->can('viewAny', SolicitacaoRegistro::class))->toBeFalse()
        ->and($this->professor->can('viewAny', SolicitacaoRegistro::class))->toBeFalse();
});

test('UserPolicy permissions across roles', function () {
    $user = new User(['id' => 110]);

    expect($this->docenteEspecial->can('viewAny', User::class))->toBeTrue()
        ->and($this->docenteEspecial->can('update', $user))->toBeTrue()
        ->and($this->tecnico->can('viewAny', User::class))->toBeFalse()
        ->and($this->professor->can('viewAny', User::class))->toBeFalse();
});
