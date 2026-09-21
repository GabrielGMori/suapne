<?php

namespace App\Enums;

enum EtniaEnum: string
{
    use EnumTrait;

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
}
