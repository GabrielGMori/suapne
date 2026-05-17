<?php

namespace App\Enums;

enum TipoDocumentoEnum: string
{
    case Documento = 'Documento';
    case Entrevista_Estudante = 'Entrevista_Estudante';
    case Ficha_CPAE = 'Ficha_CPAE';

    public function label(): string
    {
        return match ($this) {
            self::Documento => 'Documento',
            self::Entrevista_Estudante => 'Entrevista do Estudante',
            self::Ficha_CPAE => 'Ficha CPAE',
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
