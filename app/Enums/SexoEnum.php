<?php

namespace App\Enums;

enum SexoEnum: string
{
    case Masculino = 'Masculino';
    case Feminino = 'Feminino';

    public function label(): string
    {
        return match ($this) {
            self::Masculino => 'Masculino',
            self::Feminino => 'Feminino',
        };
    }
}
