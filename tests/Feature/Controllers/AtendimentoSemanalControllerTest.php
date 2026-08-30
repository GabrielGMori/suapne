<?php

use App\Enums\RoleEnum;
use App\Models\AtendimentoSemanal;
use App\Models\Curso;
use App\Models\Estudante;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('tecnico can list, view, and create atendimentos semanais', function () {
    $this->actingAs($this->tecnico)
        ->get(route('atendimentos.index'))
        ->assertStatus(200);

    $this->actingAs($this->tecnico)
        ->get(route('atendimentos.create', ['estudante' => $this->estudante]))
        ->assertStatus(200);

    $payload = [
        'estudante_id' => $this->estudante->id,
        'local' => 'Sala 102 - NAPNE',
        'data' => '2026-08-30 14:00',
        'campos' => [
            'perfilDoEstudante' => 'Estudante com TDAH.',
            'registroDoAtendimento' => 'Conversa sobre adaptações nas avaliações.',
            'encaminhamentos' => 'Orientar docentes das disciplinas do período.',
            'observacoesAdicionais' => 'Sem outras queixas.',
        ],
    ];

    $response = $this->actingAs($this->tecnico)
        ->post(route('atendimentos.store'), $payload);

    $response->assertRedirect(route('atendimentos.index'));
    $this->assertDatabaseHas('atendimentos_semanais', [
        'estudante_id' => $this->estudante->id,
        'local' => 'Sala 102 - NAPNE',
    ]);
});

test('tecnico can view own atendimento and admin can view any', function () {
    $atendimento = AtendimentoSemanal::factory()->create([
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->tecnico->id,
        'campos' => [
            'perfilDoEstudante' => 'Perfil teste',
            'registroDoAtendimento' => 'Registro teste',
            'encaminhamentos' => 'Encaminhamentos teste',
            'observacoesAdicionais' => 'Obs teste',
        ],
    ]);

    $this->actingAs($this->tecnico)
        ->get(route('atendimentos.show', $atendimento))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->get(route('atendimentos.show', $atendimento))
        ->assertStatus(200);
});

test('unauthorized user cannot access atendimentos', function () {
    $this->actingAs($this->professor)
        ->get(route('atendimentos.index'))
        ->assertStatus(404);
});
