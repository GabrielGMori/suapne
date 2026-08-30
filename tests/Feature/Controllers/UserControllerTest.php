<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
    $this->curso = Curso::factory()->create();
    $this->disciplina = Disciplina::factory()->create(['curso_id' => $this->curso->id]);
});

test('admin can manage CNAPNE and Professor accounts', function () {
    $this->actingAs($this->admin)
        ->get(route('contas.cnapne.index'))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->get(route('contas.professor.index'))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->get(route('contas.cnapne.edit', $this->tecnico))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->put(route('contas.cnapne.update', $this->tecnico), [
            'nome' => 'Tecnico Atualizado',
            'email' => 'tecnico.novo@ifpr.edu.br',
            'role' => RoleEnum::TECNICO->value,
        ])
        ->assertRedirect(route('contas.cnapne.index'));

    expect($this->tecnico->fresh()->nome)->toBe('Tecnico Atualizado');

    $this->actingAs($this->admin)
        ->get(route('contas.professor.edit', $this->professor))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->put(route('contas.professor.update', $this->professor), [
            'nome' => 'Professor Atualizado',
            'email' => 'prof.novo@ifpr.edu.br',
            'disciplinas' => [$this->disciplina->id],
        ])
        ->assertRedirect(route('contas.professor.index'));

    expect($this->professor->fresh()->disciplinas->contains('id', $this->disciplina->id))->toBeTrue();
});

test('unauthorized user cannot manage user accounts', function () {
    $this->actingAs($this->professor)
        ->get(route('contas.cnapne.index'))
        ->assertStatus(404);

    $this->actingAs($this->tecnico)
        ->get(route('contas.professor.index'))
        ->assertStatus(404);
});
