<?php

namespace App\Enums;

enum StatusPlanoTrabalhoEnum: string
{
    use EnumTrait;
    
    case PENDENTE = 'PENDENTE';
    case AGUARDANDO_REVISAO = 'AGUARDANDO_REVISAO';
    case DEVOLVIDO = 'DEVOLVIDO';
    case APROVADO = 'APROVADO';

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::AGUARDANDO_REVISAO => 'Aguardando revisão',
            self::DEVOLVIDO => 'Devolvido',
            self::APROVADO => 'Aprovado',
        };
    }

    public function color() : string
    {
        return match ($this) {
            self::PENDENTE => 'danger',
            self::AGUARDANDO_REVISAO => 'warning',
            self::DEVOLVIDO => 'danger',
            self::APROVADO => 'success',
        };
    }

    public function badgeLabel() : string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::AGUARDANDO_REVISAO => 'Aguardando',
            self::DEVOLVIDO => 'Devolvido',
            self::APROVADO => 'Aprovado',
        };
    }
}
