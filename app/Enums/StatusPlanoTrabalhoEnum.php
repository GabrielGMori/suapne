<?php

namespace App\Enums;

enum StatusPlanoTrabalhoEnum: string
{
    case Pendente = 'Pendente';
    case Aguardando_revisao = 'Aguardando_revisao';
    case Devolvido = 'Devolvido';
    case Aprovado = 'Aprovado';

    public function label(): string
    {
        return match ($this) {
            self::Pendente => 'Pendente',
            self::Aguardando_revisao => 'Aguardando revisão',
            self::Devolvido => 'Devolvido',
            self::Aprovado => 'Aprovado',
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
