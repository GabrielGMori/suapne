<?php

namespace App\Enums;

enum EtniaEnum: string
{
    case Branca = 'Branca';
    case Preta = 'Preta';
    case Parda = 'Parda';
    case Amarela = 'Amarela';
    case Indigena = 'Indigena';
    case Nao_declarada = 'Nao_declarada';

    public function label(): string
    {
        return match ($this) {
            self::Branca => 'Branca',
            self::Preta => 'Preta',
            self::Parda => 'Parda',
            self::Amarela => 'Amarela',
            self::Indigena => 'Indígena',
            self::Nao_declarada => 'Não declarada',
        };
    }
}
