<?php

namespace App\Enums;

enum SituacaoEstudanteEnum: string
{
    use EnumTrait;

    case MATRICULADO = 'MATRICULADO';
    case CONCLUIDO = 'CONCLUIDO';
    case TRANSFERIDO = 'TRANSFERIDO';
    case CANCELADO = 'CANCELADO';

    public function label(): string
    {
        return match ($this) {
            self::MATRICULADO => 'Matriculado',
            self::CONCLUIDO => 'Concluído',
            self::TRANSFERIDO => 'Transferido',
            self::CANCELADO => 'Cancelado',
        };
    }
}
