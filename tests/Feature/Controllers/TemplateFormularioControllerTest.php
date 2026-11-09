<?php

use App\Enums\RoleEnum;
use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use App\Models\User;
use App\Support\CamposTemplate;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
    $this->tipo = TipoFormularioEnum::ATENDIMENTO_SEMANAL;
});

test('admin can access the template management screens', function () {
    $this->actingAs($this->admin)
        ->get(route('templates.index'))
        ->assertStatus(200)
        ->assertSeeText('Escolha o formulário');

    $this->actingAs($this->admin)
        ->get(route('templates.tipo', ['tipo' => $this->tipo]))
        ->assertStatus(200)
        ->assertSeeText('Templates de');
});

test('admin can create and activate templates for a form', function () {
    $campos = CamposTemplate::campos($this->tipo);

    $this->actingAs($this->admin)
        ->post(route('templates.store', ['tipo' => $this->tipo]), [
            'nome' => 'Template de atendimento semanal',
            'campos' => $campos,
        ])
        ->assertRedirect(route('templates.tipo', ['tipo' => $this->tipo]))
        ->assertSessionHas('status', 'Template criado com sucesso!');

    $this->assertDatabaseHas('templates_formulario', [
        'nome' => 'Template de atendimento semanal',
        'tipo' => $this->tipo->value,
        'user_id' => $this->admin->id,
    ]);

    $template = TemplateFormulario::query()->where('nome', 'Template de atendimento semanal')->first();
    $padrao = TemplateFormulario::query()->doTipo($this->tipo)->where('padrao', true)->first();

    $this->actingAs($this->admin)
        ->patch(route('templates.ativar', ['templateFormulario' => $template]))
        ->assertRedirect(route('templates.tipo', ['tipo' => $this->tipo]))
        ->assertSessionHas('status', 'Template em uso alterado com sucesso!');

    expect($template->fresh()->ativo)->toBeTrue()
        ->and($padrao->fresh()->ativo)->toBeFalse();
});

test('non-admin users cannot access template management', function () {
    $template = TemplateFormulario::create([
        'nome' => 'Template restrito',
        'tipo' => $this->tipo,
        'campos' => CamposTemplate::campos($this->tipo),
        'user_id' => $this->admin->id,
    ]);

    $this->actingAs($this->professor)
        ->get(route('templates.index'))
        ->assertStatus(404);

    $this->actingAs($this->professor)
        ->get(route('templates.show', ['templateFormulario' => $template]))
        ->assertStatus(404);

    $this->actingAs($this->professor)
        ->post(route('templates.store', ['tipo' => $this->tipo]), [
            'nome' => 'Template bloqueado',
            'campos' => CamposTemplate::campos($this->tipo),
        ])
        ->assertStatus(404);
});
