<?php

namespace App\Support;

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CamposTemplate
{
    public const TIPOS_CAMPO = [
        'textarea' => 'Texto longo',
        'text' => 'Texto curto',
        'date' => 'Data',
        'number' => 'Número',
    ];

    public static function campos(TipoFormularioEnum $tipo): array
    {
        return match ($tipo) {
            TipoFormularioEnum::PLANO_FLEXIBILIZACAO => self::planoFlexibilizacao(),
            TipoFormularioEnum::PLANO_TRABALHO => self::planoTrabalho(),
            TipoFormularioEnum::ATENDIMENTO_SEMANAL => self::atendimentoSemanal(),
        };
    }

    public static function camposParaFormulario(TipoFormularioEnum $tipo, ?int $templateId, ?Model $registro, array $valores = []): array
    {
        $doTemplate = self::doTemplate($tipo, $templateId);
        $chavesAtuais = array_column($doTemplate, 'chave');

        $doRegistro = array_filter(
            $registro?->camposAdicionais() ?? [],
            fn($campo) => in_array($campo['chave'], $chavesAtuais, true) || filled($valores[$campo['chave']] ?? null)
        );

        $porChave = [];
        foreach ([...$doRegistro, ...$doTemplate] as $campo) {
            $porChave[$campo['chave']] ??= $campo;
        }

        return array_values($porChave);
    }

    public static function doTemplate(TipoFormularioEnum $tipo, ?int $templateId): array
    {
        $template = $templateId
            ? TemplateFormulario::query()->doTipo($tipo)->whereKey($templateId)->first()
            : null;

        return ($template ?? TemplateFormulario::padraoDe($tipo))->campos ?: self::campos($tipo);
    }

    public static function filtrar(array $campos, string $secao = '', string $etapa = '', string $ate = '', string $depois = ''): array
    {
        $campos = self::cortar($campos, $ate, $depois);

        return array_values(array_filter($campos, function ($campo) use ($secao, $etapa) {
            $etapaOk = match ($etapa) {
                '' => true,
                'livre' => !isset($campo['etapa']),
                default => ($campo['etapa'] ?? null) === $etapa,
            };

            return ($campo['secao'] ?? '') === $secao && $etapaOk;
        }));
    }

    private static function cortar(array $campos, string $ate, string $depois): array
    {
        $chave = $ate !== '' ? $ate : $depois;

        if ($chave === '') {
            return $campos;
        }

        $posicao = array_search($chave, array_column($campos, 'chave'), true);

        if ($posicao === false) {
            return $campos;
        }

        return $ate !== ''
            ? array_slice($campos, 0, $posicao)
            : array_slice($campos, $posicao + 1);
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

            $itens[] = ['grupo' => $grupo, 'titulo' => $campo['grupoTitulo'] ?? '', 'campos' => [$campo]];
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

        return [
            'chave' => $chave,
            'rotulo' => $rotulo,
            'tipo' => $tipo,
            'obrigatorio' => $obrigatorio,
            'fixo' => false,
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

    public static function motivoFixo(array $campo): ?string
    {
        return $campo['motivoFixo'] ?? null;
    }

    private static function campo(string $chave, string $rotulo, string $tipo = 'textarea', array $extra = []): array
    {
        return [
            'chave' => $chave,
            'rotulo' => $rotulo,
            'tipo' => $tipo,
            'obrigatorio' => false,
            'fixo' => false,
            ...$extra,
        ];
    }

    private static function planoFlexibilizacao(): array
    {
        $grupo = [
            'grupo' => 'flexibilizacao',
            'grupoTitulo' => 'Flexibilização Curricular, visando a implementação de 1 (uma) ou mais possibilidades',
            'opcoes' => ['Sim' => 'Sim', 'Não' => 'Não'],
        ];

        return [
            self::campo('acoesPedagogicas', 'Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular', 'textarea', [
                'descricao' => '(Registrar todas as ações pedagógicas e tentativas de adaptações realizadas até o momento)',
            ]),
            self::campo('atendimentoMultiprofissional', 'Atendimento multiprofissional', 'textarea', [
                'descricao' => 'Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante',
            ]),
            self::campo('diferenciacaoCurricular', 'I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE', 'select', $grupo),
            self::campo('atendimentoIndividualizado', 'II - Atendimento educacional individualizado realizado pelo professor do componente curricular', 'select', $grupo),
            self::campo('alteracaoPrazo', 'III - Dilação ou redução do prazo para a conclusão do curso', 'select', $grupo),
            self::campo('reorganizacaoCurricular', 'IV - Reorganização e/ou equivalência de componente curricular', 'select', $grupo),
            self::campo('criteriosDiferenciados', 'V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes.', 'select', $grupo),
            self::campo('componentesCurriculares', 'Componentes curriculares a serem flexibilizados', 'especial', [
                'regra' => 'array',
                'fixo' => true,
                'motivoFixo' => 'O plano de trabalho do estudante preenche os componentes curriculares a partir deste campo.',
            ]),
            self::campo('informacoesAdicionais', 'Informações adicionais'),
        ];
    }

    private static function planoTrabalho(): array
    {
        return [
            self::campo('cargaHoraria', 'Carga horária de atendimento individualizado', 'text', [
                'secao' => 'dadosEstudante',
                'etapa' => 'criacao',
                'rotuloFormulario' => 'Carga horária de atendimento (opcional)',
            ]),
            self::campo('local', 'Dia/Horário/Local', 'text', [
                'secao' => 'dadosEstudante',
                'etapa' => 'criacao',
                'rotuloFormulario' => 'Local',
            ]),
            self::campo('particularidadesEstudante', 'Particularidades do estudante', 'textarea', [
                'etapa' => 'criacao',
            ]),
            self::campo('objetivosEspecificos', 'Objetivos específicos para o estudante neste período', 'textarea', [
                'etapa' => 'preenchimento',
            ]),
            self::campo('instrumentosAvaliativos', 'Instrumentos avaliativos pretendidos e procedimentos adotados', 'textarea', [
                'etapa' => 'preenchimento',
                'descricao' => '(De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)',
            ]),
            self::campo('outrasConsideracoes', 'Outras considerações relevantes', 'textarea', [
                'etapa' => 'preenchimento',
            ]),
        ];
    }

    private static function atendimentoSemanal(): array
    {
        return [
            self::campo('perfilDoEstudante', 'Perfil do Estudante', 'especial', [
                'secao' => 'dadosEstudante',
                'fixo' => true,
                'motivoFixo' => 'Este campo é preenchido automaticamente com o conteúdo do último atendimento do estudante.',
            ]),
            self::campo('registroDoAtendimento', 'Registro do Atendimento'),
            self::campo('encaminhamentos', 'Encaminhamentos'),
            self::campo('observacoesAdicionais', 'Observações adicionais'),
        ];
    }
}
