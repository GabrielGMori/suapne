<?php

use App\Enums\RoleEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Models\Curso;
use App\Models\Estudante;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create(['quantidade_periodos' => 6]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('guest cannot access estudantes routes', function () {
    $this->get(route('estudantes.index'))->assertRedirect(route('login.index'));
    $this->get(route('estudantes.create'))->assertRedirect(route('login.index'));
});

test('user can list and view estudantes', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);

    $this->actingAs($this->professor)
        ->get(route('estudantes.index'))
        ->assertStatus(200);

    $this->actingAs($this->professor)
        ->get(route('estudantes.show', $estudante))
        ->assertStatus(200)
        ->assertSee($estudante->nome);
});

test('tecnico can create a new estudante', function () {
    $data = [
        'nome' => 'Estudante Teste',
        'matricula' => '20260001',
        'ingresso_ano' => 2026,
        'ingresso_periodo' => 1,
        'periodo' => 1,
        'email_academico' => '20260001@estudantes.ifpr.edu.br',
        'data_nascimento' => '2005-05-10',
        'cpf' => '12345678901',
        'necessidades' => 'Estudante com TDAH e altas habilidades.',
        'situacao' => SituacaoEstudanteEnum::MATRICULADO->value,
        'sexo' => SexoEnum::MASCULINO->value,
        'curso_id' => $this->curso->id,
    ];

    $response = $this->actingAs($this->tecnico)
        ->post(route('estudantes.store'), $data);

    $response->assertRedirect(route('estudantes.index'));
    $this->assertDatabaseHas('estudantes', [
        'matricula' => '20260001',
        'nome' => 'Estudante Teste',
    ]);
});

test('tecnico can update an existing estudante', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);

    $data = [
        'nome' => 'Nome Atualizado',
        'matricula' => $estudante->matricula,
        'ingresso_ano' => $estudante->ingresso_ano,
        'ingresso_periodo' => $estudante->ingresso_periodo,
        'periodo' => 2,
        'email_academico' => $estudante->email_academico,
        'data_nascimento' => $estudante->data_nascimento->format('Y-m-d'),
        'cpf' => $estudante->cpf,
        'situacao' => SituacaoEstudanteEnum::MATRICULADO->value,
        'sexo' => SexoEnum::FEMININO->value,
        'curso_id' => $this->curso->id,
    ];

    $response = $this->actingAs($this->tecnico)
        ->put(route('estudantes.update', $estudante), $data);

    $response->assertRedirect(route('estudantes.show', $estudante));
    expect($estudante->fresh()->nome)->toBe('Nome Atualizado')
        ->and($estudante->fresh()->periodo)->toBe(2);
});

test('admin can soft delete and restore estudante', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);

    $response = $this->actingAs($this->admin)
        ->delete(route('estudantes.destroy', $estudante));

    $response->assertRedirect(route('estudantes.index'));
    expect(Estudante::find($estudante->id))->toBeNull()
        ->and(Estudante::withTrashed()->find($estudante->id))->not->toBeNull();

    $restoreResponse = $this->actingAs($this->admin)
        ->post(route('estudantes.restore', $estudante));

    $restoreResponse->assertRedirect();
    expect(Estudante::find($estudante->id))->not->toBeNull();
});

test('professor regular cannot create or delete estudante', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);

    $this->actingAs($this->professor)
        ->get(route('estudantes.create'))
        ->assertStatus(404);

    $this->actingAs($this->professor)
        ->delete(route('estudantes.destroy', $estudante))
        ->assertStatus(404);
});
