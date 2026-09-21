<?php

namespace App\Enums;

enum TipoDocumentoEnum: string
{
    use EnumTrait;

    case DOCUMENTO = 'DOCUMENTO';
    case ENTREVISTA_ESTUDANTE = 'ENTREVISTA_ESTUDANTE';
    case LAUDO = 'LAUDO';
    case ESTUDO_DE_CASO = 'ESTUDO_DE_CASO';
    case FICHA_CPAE = 'FICHA_CPAE';

    public function label(): string
    {
        return match ($this) {
            self::DOCUMENTO => 'Documento',
            self::ENTREVISTA_ESTUDANTE => 'Entrevista do Estudante',
            self::LAUDO => 'Laudo',
            self::ESTUDO_DE_CASO => 'Estudo de Caso',
            self::FICHA_CPAE => 'Ficha CPAE',
        };
    }
}
