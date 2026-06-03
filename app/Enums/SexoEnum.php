<?php

namespace App\Enums;

enum SexoEnum: string
{
    case MASCULINO = 'MASCULINO';
    case FEMININO = 'FEMININO';

    public function label(): string
    {
        return match ($this) {
            self::MASCULINO => 'Masculino',
            self::FEMININO => 'Feminino',
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
