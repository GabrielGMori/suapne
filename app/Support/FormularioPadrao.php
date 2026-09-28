<?php

namespace App\Support;

use App\Enums\TipoFormularioEnum;
use App\Models\ModeloFormulario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormularioPadrao
{
    public const TIPOS_CAMPO = [
        'textarea' => 'Texto longo',
        'text' => 'Texto curto',
        'date' => 'Data',
        'number' => 'Número',
    ];

    public const ORDEM_PERSONALIZADO = 100;

    public static function camposAdicionais(TipoFormularioEnum $tipo): array
    {
        return match ($tipo) {
            TipoFormularioEnum::PLANO_FLEXIBILIZACAO => self::planoFlexibilizacao(),
            TipoFormularioEnum::PLANO_TRABALHO => self::planoTrabalho(),
            TipoFormularioEnum::ATENDIMENTO_SEMANAL => self::atendimentoSemanal(),
        };
    }

    public static function camposParaFormulario(TipoFormularioEnum $tipo, ?int $estudanteId, ?Model $registro, array $valores = []): array
    {
        $doEstudante = ModeloFormulario::para($tipo, $estudanteId)->campos();
        $chavesAtuais = array_column($doEstudante, 'chave');

        $doRegistro = array_filter(
            $registro?->camposAdicionais() ?? [],
            fn($campo) => in_array($campo['chave'], $chavesAtuais, true) || filled($valores[$campo['chave']] ?? null)
        );

        $porChave = [];
        foreach ([...$doRegistro, ...$doEstudante] as $campo) {
            $porChave[$campo['chave']] ??= $campo;
        }

        return array_values($porChave);
    }

    public static function filtrar(array $campos, string $secao = '', string $etapa = '', int $ordemMin = 0, ?int $ordemMax = null): array
    {
        return array_values(array_filter($campos, function ($campo) use ($secao, $etapa, $ordemMin, $ordemMax) {
            $ordem = $campo['ordem'] ?? self::ORDEM_PERSONALIZADO;
            $etapaOk = match ($etapa) {
                '' => true,
                'livre' => !isset($campo['etapa']),
                default => ($campo['etapa'] ?? null) === $etapa,
            };

            return ($campo['secao'] ?? '') === $secao
                && $etapaOk
                && $ordem >= $ordemMin
                && ($ordemMax === null || $ordem <= $ordemMax);
        }));
    }

    public static function agrupar(array $campos): array
    {
        $itens = [];

        foreach ($campos as $campo) {
            $grupo = $campo['grupo'] ?? null;

            if ($grupo === null) {
                $itens[] = ['campo' => $campo];
                continue;
            }

            $ultimo = array_key_last($itens);

            if ($ultimo !== null && ($itens[$ultimo]['grupo'] ?? null) === $grupo) {
                $itens[$ultimo]['campos'][] = $campo;
                continue;
            }

            $itens[] = [
                'grupo' => $grupo,
                'titulo' => $campo['grupoTitulo'] ?? '',
                'campos' => [$campo],
            ];
        }

        return $itens;
    }

    public static function novoCampo(string $rotulo, string $tipo, bool $obrigatorio, array $camposExistentes): array
    {
        $chaves = array_column($camposExistentes, 'chave');
        $base = Str::of($rotulo)->slug('_')->limit(40, '')->toString();
        $base = preg_replace('/^[^a-z]+/', '', $base) ?: 'campo';
        $chave = $base;
        $n = 2;

        while (in_array($chave, $chaves, true)) {
            $chave = "{$base}_{$n}";
            $n++;
        }

        $ordens = array_map(fn($campo) => $campo['ordem'] ?? self::ORDEM_PERSONALIZADO, $camposExistentes);

        return [
            'chave' => $chave,
            'rotulo' => $rotulo,
            'tipo' => $tipo,
            'obrigatorio' => $obrigatorio,
            'padrao' => false,
            'ordem' => max([self::ORDEM_PERSONALIZADO - 1, ...$ordens]) + 1,
        ];
    }

    public static function regra(array $campo): string
    {
        if (!empty($campo['regra'])) {
            return $campo['regra'];
        }

        return match ($campo['tipo'] ?? 'text') {
            'date' => 'date',
            'number' => 'numeric',
            default => 'string',
        };
    }

    private static function campo(string $chave, string $rotulo, int $ordem, string $tipo = 'textarea', array $extra = []): array
    {
        return [
            'chave' => $chave,
            'rotulo' => $rotulo,
            'tipo' => $tipo,
            'obrigatorio' => false,
            'padrao' => true,
            'ordem' => $ordem,
            ...$extra,
        ];
    }

    private static function planoFlexibilizacao(): array
    {
        $simNao = ['Sim' => 'Sim', 'Não' => 'Não'];
        $grupo = [
            'grupo' => 'flexibilizacao',
            'grupoTitulo' => '4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais possibilidades',
            'opcoes' => $simNao,
        ];

        return [
            self::campo('acoesPedagogicas', '2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular', 2, 'textarea', [
                'descricao' => '(Registrar todas as ações pedagógicas e tentativas de adaptações realizadas até o momento)',
            ]),
            self::campo('atendimentoMultiprofissional', '3. Atendimento multiprofissional', 3, 'textarea', [
                'descricao' => 'Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante',
            ]),
            self::campo('diferenciacaoCurricular', 'I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE', 4, 'select', $grupo),
            self::campo('atendimentoIndividualizado', 'II - Atendimento educacional individualizado realizado pelo professor do componente curricular', 4, 'select', $grupo),
            self::campo('alteracaoPrazo', 'III - Dilação ou redução do prazo para a conclusão do curso', 4, 'select', $grupo),
            self::campo('reorganizacaoCurricular', 'IV - Reorganização e/ou equivalência de componente curricular', 4, 'select', $grupo),
            self::campo('criteriosDiferenciados', 'V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes.', 4, 'select', $grupo),
            self::campo('componentesCurriculares', '5. Componentes curriculares a serem flexibilizados', 5, 'especial', [
                'regra' => 'array',
            ]),
            self::campo('informacoesAdicionais', '6. Informações adicionais', 6),
        ];
    }

    private static function planoTrabalho(): array
    {
        return [
            self::campo('cargaHoraria', 'Carga horária de atendimento individualizado', 1, 'text', [
                'secao' => 'dadosEstudante',
                'etapa' => 'criacao',
                'rotuloFormulario' => 'Carga horária de atendimento (opcional)',
            ]),
            self::campo('local', 'Dia/Horário/Local', 1, 'text', [
                'secao' => 'dadosEstudante',
                'etapa' => 'criacao',
                'rotuloFormulario' => 'Local',
            ]),
            self::campo('particularidadesEstudante', '2. Particularidades do estudante', 2, 'textarea', [
                'etapa' => 'criacao',
            ]),
            self::campo('objetivosEspecificos', '4. Objetivos específicos para o estudante neste período', 4, 'textarea', [
                'etapa' => 'preenchimento',
            ]),
            self::campo('instrumentosAvaliativos', '5. Instrumentos avaliativos pretendidos e procedimentos adotados:', 5, 'textarea', [
                'etapa' => 'preenchimento',
                'descricao' => '(De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)',
            ]),
            self::campo('outrasConsideracoes', '6. Outras considerações relevantes:', 6, 'textarea', [
                'etapa' => 'preenchimento',
            ]),
        ];
    }

    private static function atendimentoSemanal(): array
    {
        return [
            self::campo('perfilDoEstudante', 'Perfil do Estudante', 1, 'especial', [
                'secao' => 'dadosEstudante',
            ]),
            self::campo('registroDoAtendimento', '2. Registro do Atendimento', 2),
            self::campo('encaminhamentos', '3. Encaminhamentos', 3),
            self::campo('observacoesAdicionais', '4. Observações adicionais', 4),
        ];
    }
}
