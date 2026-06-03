<?php

namespace App\Enums;

enum TipoRegistroAcaoEnum: string
{
    case CRIACAO = 'CRIACAO';
    case EDICAO = 'EDICAO';
    case EXCLUSAO = 'EXCLUSAO';

    public function label(): string
    {
        return match ($this) {
            self::CRIACAO => 'Criação',
            self::EDICAO => 'Edição',
            self::EXCLUSAO => 'Exclusão',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CRIACAO => 'primary',
            self::EDICAO => 'secondary',
            self::EXCLUSAO => 'danger',
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
