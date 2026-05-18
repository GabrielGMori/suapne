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

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
