<?php

use App\Enums\RoleEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;
use App\Notifications\PlanoTrabalhoAtribuido;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->disciplina = Disciplina::factory()->create(['curso_id' => $this->curso->id]);
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
    $this->professor->disciplinas()->attach($this->disciplina->id);
});

test('tecnico can list, preview, and create planos de trabalho', function () {
    Notification::fake();

    $this->actingAs($this->tecnico)
        ->get(route('planos-trabalho.index'))
        ->assertStatus(200);

    $this->actingAs($this->tecnico)
        ->get(route('planos-trabalho.create', ['estudante' => $this->estudante]))
        ->assertStatus(200);

    $payload = [
        'status' => StatusPlanoTrabalhoEnum::PENDENTE->value,
        'estudante_id' => $this->estudante->id,
        'disciplinas' => [$this->disciplina->id],
        'professores' => [$this->professor->id],
        'periodo_inicio' => '2026-02-01',
        'periodo_fim' => '2026-12-20',
        'campos' => [
            'local' => 'Sala 10',
            'particularidadesEstudante' => 'Dificuldade de concentração.',
            'objetivosEspecificos' => 'Acompanhamento contínuo.',
            'instrumentosAvaliativos' => 'Avaliações contínuas.',
        ],
    ];

    $response = $this->actingAs($this->tecnico)
        ->post(route('planos-trabalho.store'), $payload);

    $response->assertRedirect(route('planos-trabalho.index'));

    $this->assertDatabaseHas('planos_trabalho_estudante', [
        'estudante_id' => $this->estudante->id,
        'disciplina_id' => $this->disciplina->id,
        'user_professor_id' => $this->professor->id,
    ]);

    Notification::assertSentTo($this->professor, PlanoTrabalhoAtribuido::class);
});

test('professor can view assigned plano and export pdf', function () {
    $plano = PlanoTrabalhoEstudante::create([
        'status' => StatusPlanoTrabalhoEnum::PENDENTE,
        'estudante_id' => $this->estudante->id,
        'disciplina_id' => $this->disciplina->id,
        'user_professor_id' => $this->professor->id,
        'user_id' => $this->tecnico->id,
        'periodo_inicio' => '2026-02-01',
        'periodo_fim' => '2026-12-20',
        'campos' => [
            'local' => 'Sala 10',
        ],
    ]);

    $this->actingAs($this->professor)
        ->get(route('planos-trabalho.show', $plano))
        ->assertStatus(200);

    $this->actingAs($this->professor)
        ->get(route('planos-trabalho.export-pdf', $plano))
        ->assertStatus(200);
});

test('professor cannot view unassigned plano de trabalho', function () {
    $otherProfessor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);

    $plano = PlanoTrabalhoEstudante::create([
        'status' => StatusPlanoTrabalhoEnum::PENDENTE,
        'estudante_id' => $this->estudante->id,
        'disciplina_id' => $this->disciplina->id,
        'user_professor_id' => $otherProfessor->id,
        'user_id' => $this->tecnico->id,
        'periodo_inicio' => '2026-02-01',
        'periodo_fim' => '2026-12-20',
        'campos' => [],
    ]);

    $this->actingAs($this->professor)
        ->get(route('planos-trabalho.show', $plano))
        ->assertStatus(404);
});
