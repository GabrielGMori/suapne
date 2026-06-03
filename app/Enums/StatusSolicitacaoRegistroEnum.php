<?php

namespace App\Enums;

enum StatusSolicitacaoRegistroEnum: string
{
    case PENDENTE = 'PENDENTE';
    case ACEITA = 'ACEITA';
    case RECUSADA = 'RECUSADA';

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::ACEITA => 'Aceita',
            self::RECUSADA => 'Recusada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDENTE => 'warning',
            self::ACEITA => 'success',
            self::RECUSADA => 'danger',
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
