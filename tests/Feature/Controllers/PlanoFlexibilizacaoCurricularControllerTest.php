<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->disciplina = Disciplina::factory()->create(['curso_id' => $this->curso->id]);
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('tecnico can list, view and create plano de flexibilizacao curricular', function () {
    $this->actingAs($this->tecnico)
        ->get(route('planos-flexibilizacao.index'))
        ->assertStatus(200);

    $this->actingAs($this->tecnico)
        ->get(route('planos-flexibilizacao.create', ['estudante' => $this->estudante]))
        ->assertStatus(200);

    $payload = [
        'estudante_id' => $this->estudante->id,
        'periodo_inicio' => '2026-02-01',
        'periodo_fim' => '2026-12-20',
        'campos' => [
            'acoesPedagogicas' => 'Tempo adicional nas provas.',
            'atendimentoMultiprofissional' => 'Acompanhamento psicológico quinzenal.',
            'diferenciacaoCurricular' => 'Não necessária.',
            'atendimentoIndividualizado' => 'Sim, no contraturno.',
            'alteracaoPrazo' => 'Prazos flexíveis para entrega de trabalhos.',
            'reorganizacaoCurricular' => 'Não.',
            'criteriosDiferenciados' => 'Avaliações orais e escritas.',
            'componentesCurriculares' => [$this->disciplina->nome],
            'informacoesAdicionais' => 'Tudo alinhado com a família.',
        ],
    ];

    $response = $this->actingAs($this->tecnico)
        ->post(route('planos-flexibilizacao.store'), $payload);

    $response->assertRedirect(route('planos-flexibilizacao.index'));

    $this->assertDatabaseHas('planos_flexibilizacao_curricular', [
        'estudante_id' => $this->estudante->id,
    ]);
});

test('user can view and export pdf of plano de flexibilizacao', function () {
    $plano = PlanoFlexibilizacaoCurricular::create([
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->tecnico->id,
        'periodo_inicio' => '2026-02-01',
        'periodo_fim' => '2026-12-20',
        'campos' => [
            'acoesPedagogicas' => 'Tempo extra.',
        ],
    ]);

    $this->actingAs($this->tecnico)
        ->get(route('planos-flexibilizacao.show', $plano))
        ->assertStatus(200);

    $response = $this->actingAs($this->tecnico)
        ->get(route('planos-flexibilizacao.exportPdf', ['planoFlexibilizacao' => $plano]));

    $response->assertStatus(200);
});

test('unauthorized user cannot access planos de flexibilizacao', function () {
    $this->actingAs($this->professor)
        ->get(route('planos-flexibilizacao.index'))
        ->assertStatus(404);
});
