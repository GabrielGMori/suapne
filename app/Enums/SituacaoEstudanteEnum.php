<?php

namespace App\Enums;

enum SituacaoEstudanteEnum: string
{
    case Matriculado = 'Matriculado';
    case Formado = 'Formado';
    case Cancelado = 'Cancelado';

    public function label(): string
    {
        return match ($this) {
            self::Matriculado => 'Matriculado',
            self::Formado => 'Formado',
            self::Cancelado => 'Cancelado',
        };
    }
}
