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

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
