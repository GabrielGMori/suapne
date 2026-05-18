<?php

namespace App\Enums;

enum RoleEnum: string
{
    case PROFESSOR_REGULAR = 'PROFESSOR_REGULAR';
    case DOCENTE_ESPECIAL = 'DOCENTE_ESPECIAL';
    case TECNICO = 'TECNICO';

    public function label(): string
    {
        return match ($this) {
            self::PROFESSOR_REGULAR => 'Professor de Ensino Regular',
            self::DOCENTE_ESPECIAL => 'Docente de Ed. Especial',
            self::TECNICO => 'Técnico de Ed. Especial',
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
