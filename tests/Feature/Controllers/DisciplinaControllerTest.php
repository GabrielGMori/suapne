<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create(['quantidade_periodos' => 6]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('admin can list, create, edit, and update disciplinas', function () {
    $disciplina = Disciplina::factory()->create([
        'curso_id' => $this->curso->id,
        'nome' => 'Algoritmos',
    ]);

    $this->actingAs($this->admin)
        ->get(route('disciplinas.index'))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->post(route('disciplinas.store'), [
            'nome' => 'Banco de Dados',
            'ementa' => 'Introdução a SQL e modelagem relacional.',
            'curso_periodo' => 2,
            'curso_id' => $this->curso->id,
        ])
        ->assertRedirect(route('disciplinas.index'));

    $this->assertDatabaseHas('disciplinas', ['nome' => 'Banco de Dados']);

    $this->actingAs($this->admin)
        ->get(route('disciplinas.edit', $disciplina))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->put(route('disciplinas.update', $disciplina), [
            'nome' => 'Algoritmos e Estruturas de Dados',
            'ementa' => 'Conteúdo atualizado.',
            'curso_periodo' => 1,
            'curso_id' => $this->curso->id,
        ])
        ->assertRedirect(route('disciplinas.index'));

    expect($disciplina->fresh()->nome)->toBe('Algoritmos e Estruturas de Dados');
});

test('unauthorized user cannot access disciplina management', function () {
    $disciplina = Disciplina::factory()->create(['curso_id' => $this->curso->id]);

    $this->actingAs($this->professor)
        ->get(route('disciplinas.index'))
        ->assertStatus(404);

    $this->actingAs($this->professor)
        ->post(route('disciplinas.store'), [
            'nome' => 'Redes',
            'ementa' => 'TCP/IP',
            'curso_periodo' => 1,
            'curso_id' => $this->curso->id,
        ])
        ->assertStatus(403);
});
