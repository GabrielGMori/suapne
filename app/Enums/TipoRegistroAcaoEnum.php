<?php

namespace App\Enums;

enum TipoRegistroAcaoEnum: string
{
    case CRIACAO_ESTUDANTE = 'CRIACAO_ESTUDANTE';
    case EDICAO_ESTUDANTE = 'EDICAO_ESTUDANTE';
    case EXCLUSAO_ESTUDANTE = 'EXCLUSAO_ESTUDANTE';

    case CRIACAO_DOCUMENTO = 'CRIACAO_DOCUMENTO';
    case EXCLUSAO_DOCUMENTO = 'EXCLUSAO_DOCUMENTO';

    public function label(): string
    {
        return match ($this) {
            self::CRIACAO_ESTUDANTE => 'Criação de estudante',
            self::EDICAO_ESTUDANTE => 'Edição de estudante',
            self::EXCLUSAO_ESTUDANTE => 'Exclusão de estudante',
            self::CRIACAO_DOCUMENTO => 'Criação de documento',
            self::EXCLUSAO_DOCUMENTO => 'Exclusão de documento'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CRIACAO_ESTUDANTE => 'primary',
            self::EDICAO_ESTUDANTE => 'secondary',
            self::EXCLUSAO_ESTUDANTE => 'danger',
            self::CRIACAO_DOCUMENTO => 'primary',
            self::EXCLUSAO_DOCUMENTO => 'danger',
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
