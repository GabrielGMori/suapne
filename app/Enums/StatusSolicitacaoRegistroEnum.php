<?php

namespace App\Enums;

enum StatusSolicitacaoRegistroEnum: string
{
    use EnumTrait;
    
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
}
