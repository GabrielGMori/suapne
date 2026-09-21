<?php

namespace App\Enums;

enum SexoEnum: string
{
    use EnumTrait;

    case MASCULINO = 'MASCULINO';
    case FEMININO = 'FEMININO';

    public function label(): string
    {
        return match ($this) {
            self::MASCULINO => 'Masculino',
            self::FEMININO => 'Feminino',
        };
    }
}
