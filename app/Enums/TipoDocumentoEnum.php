<?php

namespace App\Enums;

enum TipoDocumentoEnum: string
{
    case Documento = 'Documento';
    case Entrevista_Estudante = 'Entrevista_Estudante';
    case Laudo = 'Laudo';
    case Estudo_de_Caso = 'Estudo_de_Caso';
    case Ficha_CPAE = 'Ficha_CPAE';

    public function label(): string
    {
        return match ($this) {
            self::Documento => 'Documento',
            self::Entrevista_Estudante => 'Entrevista do Estudante',
            self::Laudo => 'Laudo',
            self::Estudo_de_Caso => 'Estudo de Caso',
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

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
