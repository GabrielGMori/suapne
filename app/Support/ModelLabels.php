<?php

namespace App\Support;

use App\Models\AtendimentoSemanal;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Documento;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\ModeloFormulario;
use App\Models\ObservacaoEstudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\SolicitacaoRegistro;
use App\Models\User;

class ModelLabels
{
    private const INFO = [
        AtendimentoSemanal::class => ['Atendimento Semanal', 'o'],
        Curso::class => ['Curso', 'o'],
        Disciplina::class => ['Disciplina', 'a'],
        Documento::class => ['Documento', 'o'],
        EntrevistaFamiliar::class => ['Entrevista Familiar', 'a'],
        Estudante::class => ['Estudante', 'a'],
        ModeloFormulario::class => ['Campos do Formulário', 'os'],
        ObservacaoEstudante::class => ['Observação do Estudante', 'a'],
        PlanoFlexibilizacaoCurricular::class => ['Plano de Flexibilização Curricular', 'o'],
        PlanoTrabalhoEstudante::class => ['Plano de Trabalho do Estudante', 'o'],
        SolicitacaoRegistro::class => ['Solicitação de Registro', 'a'],
        User::class => ['Conta de Usuário', 'da'],
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
}
