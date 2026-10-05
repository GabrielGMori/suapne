<?php

namespace App\Support;

use App\Models\AtendimentoSemanal;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Documento;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\SolicitacaoRegistro;
use App\Models\User;
use function in_array;

class ModelLabels
{
    private const INFO = [
        Estudante::class => ['Estudante', 'a'],
        AtendimentoSemanal::class => ['Atendimento Semanal', 'o'],
        Curso::class => ['Curso', 'o'],
        Disciplina::class => ['Disciplina', 'a'],
        Documento::class => ['Documento', 'o'],
        EntrevistaFamiliar::class => ['Entrevista Familiar', 'a'],
        ObservacaoEstudante::class => ['Observação do Estudante', 'a'],
        PlanoFlexibilizacaoCurricular::class => ['Plano de Flexibilização Curricular', 'o'],
        PlanoTrabalhoEstudante::class => ['Plano de Trabalho do Estudante', 'o'],
        SolicitacaoRegistro::class => ['Solicitação de Registro', 'a'],
        User::class => ['Conta de Usuário', 'da'],
    ];

    private const CANT_DELETE = [
        'Documento', 'Entrevista Familiar', 'Observação do Estudante', 'Conta de Usuário',
        'Curso', 'Disciplina', 'Solicitação de Registro'
    ];

    public static function label(?string $class): string
    {
        return self::INFO[$class][0] ?? 'Registro';
    }

    public static function article(?string $class): string
    {
        return self::INFO[$class][1] ?? 'do';
    }

    public static function options(): array
    {
        return array_map(fn ($info) => $info[0], self::INFO);
    }

    public static function tableOptions(): array
    {
        return array_map(fn ($info) => !in_array($info[0], self::CANT_DELETE) ? $info[0] : null, self::INFO);
    }
}
