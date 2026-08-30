<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('authenticated user can add observation to student', function () {
    $response = $this->actingAs($this->tecnico)
        ->post(route('estudantes.observacoes.store', ['estudante' => $this->estudante]), [
            'observacao' => 'Estudante compareceu ao acolhimento inicial.',
        ]);

    $response->assertRedirect(route('estudantes.show', $this->estudante));

    $this->assertDatabaseHas('observacoes_estudante', [
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->tecnico->id,
        'observacao' => 'Estudante compareceu ao acolhimento inicial.',
    ]);
});

test('author or admin can remove student observation', function () {
    $obs = ObservacaoEstudante::create([
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->tecnico->id,
        'observacao' => 'Observação para remover.',
    ]);

    $response = $this->actingAs($this->tecnico)
        ->delete(route('estudantes.observacoes.destroy', [
            'estudante' => $this->estudante,
            'observacaoEstudante' => $obs,
        ]));

    $response->assertRedirect();
    expect(ObservacaoEstudante::find($obs->id))->toBeNull();
});

test('non-author regular user cannot delete another user observation', function () {
    $obs = ObservacaoEstudante::create([
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->admin->id,
        'observacao' => 'Observação do admin.',
    ]);

    $this->actingAs($this->professor)
        ->delete(route('estudantes.observacoes.destroy', [
            'estudante' => $this->estudante,
            'observacaoEstudante' => $obs,
        ]))
        ->assertStatus(404);
});
