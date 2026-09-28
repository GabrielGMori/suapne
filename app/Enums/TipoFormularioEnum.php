<?php

namespace App\Enums;

enum TipoFormularioEnum: string
{
    use EnumTrait;

    case PLANO_FLEXIBILIZACAO = 'PLANO_FLEXIBILIZACAO';
    case PLANO_TRABALHO = 'PLANO_TRABALHO';
    case ATENDIMENTO_SEMANAL = 'ATENDIMENTO_SEMANAL';

    public function label(): string
    {
        return match ($this) {
            self::PLANO_FLEXIBILIZACAO => 'Plano de Flexibilização Curricular',
            self::PLANO_TRABALHO => 'Plano de Trabalho do Estudante',
            self::ATENDIMENTO_SEMANAL => 'Atendimento Semanal',
        };
    }
}
