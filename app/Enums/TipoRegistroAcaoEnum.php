<?php

namespace App\Enums;

enum TipoRegistroAcaoEnum: string
{
    case Criacao = 'Criacao';
    case Edicao = 'Edicao';
    case Exclusao = 'Exclusao';

    public function label(): string
    {
        return match ($this) {
            self::Criacao => 'Criação',
            self::Edicao => 'Edição',
            self::Exclusao => 'Exclusão',
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
