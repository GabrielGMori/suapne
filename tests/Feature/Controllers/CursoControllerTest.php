<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('admin can list, create, edit, and update cursos', function () {
    $curso = Curso::factory()->create(['nome' => 'Informática']);

    $this->actingAs($this->admin)
        ->get(route('cursos.index'))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->post(route('cursos.store'), [
            'nome' => 'Mecânica',
            'quantidade_periodos' => 8,
        ])
        ->assertRedirect(route('cursos.index'));

    $this->assertDatabaseHas('cursos', ['nome' => 'Mecânica']);

    $this->actingAs($this->admin)
        ->get(route('cursos.edit', $curso))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->put(route('cursos.update', $curso), [
            'nome' => 'Informática Avançada',
            'quantidade_periodos' => 6,
        ])
        ->assertRedirect(route('cursos.index', $curso));

    expect($curso->fresh()->nome)->toBe('Informática Avançada');
});

test('unauthorized users cannot access curso management', function () {
    $curso = Curso::factory()->create();

    $this->actingAs($this->professor)
        ->get(route('cursos.index'))
        ->assertStatus(404);

    $this->actingAs($this->professor)
        ->post(route('cursos.store'), ['nome' => 'Robótica', 'quantidade_periodos' => 4])
        ->assertStatus(403);
});
