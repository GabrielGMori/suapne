<?php

use App\Enums\EtniaEnum;
use App\Enums\RoleEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Enums\TipoDocumentoEnum;

test('RoleEnum provides expected options and labels', function () {
    expect(RoleEnum::options())->toBeArray()
        ->and(RoleEnum::DOCENTE_ESPECIAL->label())->toBe('Docente de Ed. Especial')
        ->and(RoleEnum::TECNICO->label())->toBe('Técnico de Ed. Especial')
        ->and(RoleEnum::PROFESSOR_REGULAR->label())->toBe('Professor de Ensino Regular');
});

test('StatusPlanoTrabalhoEnum provides expected colors and labels', function () {
    expect(StatusPlanoTrabalhoEnum::PENDENTE->label())->toBe('Pendente')
        ->and(StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO->label())->toBe('Aguardando revisão')
        ->and(StatusPlanoTrabalhoEnum::APROVADO->label())->toBe('Aprovado')
        ->and(StatusPlanoTrabalhoEnum::DEVOLVIDO->label())->toBe('Devolvido');
});

test('StatusSolicitacaoRegistroEnum provides expected options and labels', function () {
    expect(StatusSolicitacaoRegistroEnum::PENDENTE->label())->toBe('Pendente')
        ->and(StatusSolicitacaoRegistroEnum::options())->toBeArray();
});

test('TipoDocumentoEnum provides expected labels and options', function () {
    expect(TipoDocumentoEnum::options())->toBeArray()
        ->and(TipoDocumentoEnum::LAUDO->label())->toBe('Laudo')
        ->and(TipoDocumentoEnum::DOCUMENTO->label())->toBe('Documento');
});

test('Estudante Enums provide expected cases', function () {
    expect(SexoEnum::options())->toBeArray()
        ->and(EtniaEnum::options())->toBeArray()
        ->and(SituacaoEstudanteEnum::options())->toBeArray();
});
