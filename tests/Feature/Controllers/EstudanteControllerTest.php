<?php

use App\Enums\RoleEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Models\AtendimentoSemanal;
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

test('lixeira can render trashed records from a deleted student without crashing', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $atendimento = AtendimentoSemanal::factory()->create([
        'estudante_id' => $estudante->id,
        'user_id' => $this->tecnico->id,
    ]);

    $estudante->delete();
    $atendimento->delete();

    $trashedAtendimento = AtendimentoSemanal::withTrashed()->find($atendimento->id);

    expect($trashedAtendimento->nome)->toContain($estudante->nome)
        ->and($trashedAtendimento->nome)->toContain('(Excluído)')
        ->and($trashedAtendimento->estudante)->not->toBeNull()
        ->and($trashedAtendimento->estudante->nome)->toBe($estudante->nome);

    $this->actingAs($this->admin)
        ->get('/lixeira?model=' . urlencode(AtendimentoSemanal::class))
        ->assertOk();
});

test('related tables show deleted student names with suffix, while direct student table does not', function () { 
    $activeEstudante = Estudante::factory()->create(['curso_id' => $this->curso->id, 'nome' => 'Aluno Ativo']);
    $trashedEstudante = Estudante::factory()->create(['curso_id' => $this->curso->id, 'nome' => 'Aluno de Teste']);
    $atendimento = AtendimentoSemanal::factory()->create([
        'estudante_id' => $trashedEstudante->id,
        'user_id' => $this->tecnico->id,
    ]);

    $this->actingAs($this->admin)
        ->get(route('estudantes.index'))
        ->assertOk()
        ->assertSee('Aluno Ativo')
        ->assertDontSee('Aluno Ativo (Excluído)');

    $trashedEstudante->delete();

    expect(AtendimentoSemanal::withTrashed()->find($atendimento->id)->nome)
        ->toContain('Aluno de Teste')
        ->toContain('(Excluído)');

    $atendimento->delete();
});

test('restoring a student restores related soft deleted records', function () {
    $estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $atendimento = AtendimentoSemanal::factory()->create([
        'estudante_id' => $estudante->id,
        'user_id' => $this->tecnico->id,
    ]);

    $estudante->delete();
    $atendimento->delete();

    $this->actingAs($this->admin)
        ->post(route('estudantes.restore', $estudante))
        ->assertRedirect();

    expect(AtendimentoSemanal::withTrashed()->find($atendimento->id))->not->toBeNull()
        ->and(AtendimentoSemanal::find($atendimento->id))->not->toBeNull();
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
