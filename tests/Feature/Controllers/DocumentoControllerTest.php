<?php

use App\Enums\RoleEnum;
use App\Enums\TipoDocumentoEnum;
use App\Models\Curso;
use App\Models\Estudante;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->professor = User::factory()->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
});

test('admin can upload documents for student', function () {
    $this->actingAs($this->admin)
        ->get(route('estudantes.documentos.create', [
            'estudante' => $this->estudante,
            'tipoDocumento' => 'laudo',
        ]))
        ->assertStatus(200);

    $payload = [
        'documentos' => [
            [
                'nome_arquivo' => 'laudo_medico.pdf',
                'extensao' => 'pdf',
                'path' => 'documentos/laudo_medico.pdf',
            ],
        ],
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('estudantes.documentos.store', [
            'estudante' => $this->estudante,
            'tipoDocumento' => TipoDocumentoEnum::LAUDO->value,
        ]), $payload);

    $response->assertRedirect(route('estudantes.show', ['estudante' => $this->estudante]));

    $this->assertDatabaseHas('documentos', [
        'estudante_id' => $this->estudante->id,
        'nome_arquivo' => 'laudo_medico.pdf',
        'tipo' => TipoDocumentoEnum::LAUDO->value,
    ]);
});

test('unauthorized user cannot upload documents', function () {
    $this->actingAs($this->professor)
        ->get(route('estudantes.documentos.create', ['estudante' => $this->estudante]))
        ->assertStatus(404);
});
