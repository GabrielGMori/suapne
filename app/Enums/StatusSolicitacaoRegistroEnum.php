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
}
