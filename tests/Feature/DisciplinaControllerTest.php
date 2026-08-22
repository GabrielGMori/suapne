<?php

use App\Models\Curso;
use App\Models\Disciplina;

test('disciplina can be updated via patch route', function () {
    $curso = Curso::factory()->create();
    $disciplina = Disciplina::factory()->create([
        'curso_id' => $curso->id,
        'nome' => 'Nome antigo',
        'ementa' => 'Ementa antiga',
    ]);

    $response = $this->patch(route('disciplinas.update', $disciplina), [
        'nome' => 'Nome novo',
        'ementa' => 'Ementa nova',
        'curso_id' => $curso->id,
    ]);

    $response->assertRedirect(route('disciplinas.index'));

    $disciplina->refresh();
    expect($disciplina->nome)->toBe('Nome novo');
    expect($disciplina->ementa)->toBe('Ementa nova');
});
