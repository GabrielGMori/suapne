<?php

namespace App\Enums;

enum SituacaoEstudanteEnum: string
{
    case MATRICULADO = 'MATRICULADO';
    case FORMADO = 'FORMADO';
    case CANCELADO = 'CANCELADO';

    public function label(): string
    {
        return match ($this) {
            self::MATRICULADO => 'Matriculado',
            self::FORMADO => 'Formado',
            self::CANCELADO => 'Cancelado',
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
