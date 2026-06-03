<?php

namespace App\Enums;

enum EtniaEnum: string
{
    case BRANCA = 'BRANCA';
    case PRETA = 'PRETA';
    case PARDA = 'PARDA';
    case AMARELA = 'AMARELA';
    case INDIGENA = 'INDIGENA';
    case NAO_DECLARADA = 'NAO_DECLARADA';

    public function label(): string
    {
        return match ($this) {
            self::BRANCA => 'Branca',
            self::PRETA => 'Preta',
            self::PARDA => 'Parda',
            self::AMARELA => 'Amarela',
            self::INDIGENA => 'Indígena',
            self::NAO_DECLARADA => 'Não declarada',
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
