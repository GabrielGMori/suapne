<?php

namespace App\Support;

use App\Enums\TipoFormularioEnum;
use App\Models\TemplateFormulario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CamposTemplate
{
    public const TIPOS_CAMPO = [
        'textarea' => 'Texto longo',
        'text' => 'Texto curto',
        'date' => 'Data',
        'number' => 'Número',
        'select' => 'Caixa de seleção',
    ];

    public const CONTEUDOS = 'conteudosComponente';

    public const SEM_SECAO = 'nenhuma';

    public const NOVA_SECAO = 'nova';

    public static function campos(TipoFormularioEnum $tipo): array
    {
        return match ($tipo) {
            TipoFormularioEnum::PLANO_FLEXIBILIZACAO => self::planoFlexibilizacao(),
            TipoFormularioEnum::PLANO_TRABALHO => self::planoTrabalho(),
            TipoFormularioEnum::ATENDIMENTO_SEMANAL => self::atendimentoSemanal(),
            TipoFormularioEnum::ENTREVISTA_FAMILIAR => self::entrevistaFamiliar(),
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

    public static function decodificar(array $campos): array
    {
        return array_map(fn($campo) => is_string($campo) ? json_decode($campo, true) : $campo, $campos);
    }

    public static function ordenar(array $campos): array
    {
        $noTopo = array_filter($campos, fn($campo) => filled($campo['secao'] ?? null));

        return array_values([...$noTopo, ...array_diff_key($campos, $noTopo)]);
    }

    public static function numeracao(TipoFormularioEnum $tipo, array $campos): array
    {
        $campos = self::filtrar($campos);

        if ($tipo === TipoFormularioEnum::PLANO_TRABALHO) {
            $campos = [
                ...self::filtrar($campos, etapa: 'criacao'),
                ['chave' => self::CONTEUDOS],
                ...self::filtrar($campos, etapa: 'preenchimento'),
                ...self::filtrar($campos, etapa: 'livre'),
            ];
        }

        $numeros = [];
        $numero = 1;

        foreach (self::agrupar($campos) as $item) {
            if ($item['campos'][0]['semNumero'] ?? false) {
                continue;
            }

            $numero++;

            foreach ($item['campos'] ?? [$item['campo']] as $campo) {
                $numeros[$campo['chave']] = $numero;
            }
        }

        return $numeros;
    }

    public static function formato(array $campo): string
    {
        return match ($campo['tipo'] ?? 'text') {
            'especial' => ($campo['regra'] ?? null) === 'array' ? 'Seleção múltipla' : 'Texto longo',
            'tel' => 'Telefone',
            'email' => 'E-mail',
            default => self::TIPOS_CAMPO[$campo['tipo']] ?? 'Texto curto',
        };
    }

    public static function titulo(?int $numero, string $texto): string
    {
        return $numero ? "{$numero}. {$texto}" : $texto;
    }

    public static function novoCampo(string $rotulo, string $tipo, bool $obrigatorio, array $camposExistentes, array $opcoes = []): array
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
            ...($tipo === 'select' ? ['opcoes' => array_combine($opcoes, $opcoes)] : []),
        ];
    }

    public static function secoesDisponiveis(TipoFormularioEnum $tipo, array $campos): array
    {
        $opcoes = [self::SEM_SECAO => 'Nenhuma (campo separado)'];

        if ($tipo === TipoFormularioEnum::ENTREVISTA_FAMILIAR) {
            $opcoes['secao:dadosEstudante'] = 'Identificação do Estudante';
        }

        foreach ($campos as $campo) {
            if (filled($campo['grupo'] ?? null)) {
                $opcoes["grupo:{$campo['grupo']}"] ??= $campo['grupoTitulo'] ?? $campo['grupo'];
            }
        }

        return [...$opcoes, self::NOVA_SECAO => 'Nova seção'];
    }

    public static function inserir(array $campos, array $novo, string $secao, string $titulo = ''): array
    {
        if ($secao === self::NOVA_SECAO) {
            $grupos = array_filter(array_column($campos, 'grupo'));
            $base = Str::of($titulo)->slug('_')->limit(40, '')->toString() ?: 'secao';
            $grupo = $base;
            $n = 2;

            while (in_array($grupo, $grupos, true)) {
                $grupo = "{$base}_{$n}";
                $n++;
            }

            return [...$campos, [...$novo, 'grupo' => $grupo, 'grupoTitulo' => $titulo]];
        }

        [$atributo, $valor] = explode(':', $secao, 2) + [1 => null];
        $herdados = match ($atributo) {
            'grupo' => ['grupo', 'grupoTitulo', 'semNumero'],
            'secao' => ['secao'],
            default => null,
        };

        $ultimo = null;

        foreach ($campos as $indice => $campo) {
            if ($herdados !== null && ($campo[$atributo] ?? null) === $valor) {
                $ultimo = $indice;
            }
        }

        if ($ultimo === null) {
            return [...$campos, $novo];
        }

        array_splice($campos, $ultimo + 1, 0, [[...$novo, ...array_intersect_key($campos[$ultimo], array_flip($herdados))]]);

        return $campos;
    }

    public static function regra(array $campo): string
    {
        if (!empty($campo['regra'])) {
            return $campo['regra'];
        }

        return match ($campo['tipo'] ?? 'text') {
            'date' => 'date',
            'number' => 'numeric',
            'email' => 'email',
            'select' => (string) Rule::in(array_keys($campo['opcoes'] ?? [])),
            default => 'string',
        };
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
            'obrigatorio' => true,
        ];

        return [
            self::campo('acoesPedagogicas', 'Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular', 'textarea', [
                'obrigatorio' => true,
                'descricao' => '(Registrar todas as ações pedagógicas e tentativas de adaptações realizadas até o momento)',
            ]),
            self::campo('atendimentoMultiprofissional', 'Atendimento multiprofissional', 'textarea', [
                'obrigatorio' => true,
                'descricao' => 'Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante',
            ]),
            self::campo('diferenciacaoCurricular', 'I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE', 'select', $grupo),
            self::campo('atendimentoIndividualizado', 'II - Atendimento educacional individualizado realizado pelo professor do componente curricular', 'select', $grupo),
            self::campo('alteracaoPrazo', 'III - Dilação ou redução do prazo para a conclusão do curso', 'select', $grupo),
            self::campo('reorganizacaoCurricular', 'IV - Reorganização e/ou equivalência de componente curricular', 'select', $grupo),
            self::campo('criteriosDiferenciados', 'V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes.', 'select', $grupo),
            self::campo('componentesCurriculares', 'Componentes curriculares a serem flexibilizados', 'especial', [
                'regra' => 'array',
                'obrigatorio' => true,
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
                'obrigatorio' => true,
                'rotuloFormulario' => 'Local',
            ]),
            self::campo('particularidadesEstudante', 'Particularidades do estudante', 'textarea', [
                'etapa' => 'criacao',
                'obrigatorio' => true,
            ]),
            self::campo('objetivosEspecificos', 'Objetivos específicos para o estudante neste período', 'textarea', [
                'etapa' => 'preenchimento',
                'obrigatorio' => true,
            ]),
            self::campo('instrumentosAvaliativos', 'Instrumentos avaliativos pretendidos e procedimentos adotados', 'textarea', [
                'etapa' => 'preenchimento',
                'obrigatorio' => true,
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
                'obrigatorio' => true,
                'fixo' => true,
                'motivoFixo' => 'Este campo é preenchido automaticamente com o conteúdo do último atendimento do estudante.',
            ]),
            self::campo('registroDoAtendimento', 'Registro do Atendimento', 'textarea', ['obrigatorio' => true]),
            self::campo('encaminhamentos', 'Encaminhamentos', 'textarea', ['obrigatorio' => true]),
            self::campo('observacoesAdicionais', 'Observações adicionais'),
        ];
    }

    private static function entrevistaFamiliar(): array
    {
        $simNao = ['Sim' => 'Sim', 'Não' => 'Não'];
        $identificacao = ['secao' => 'dadosEstudante'];
        $curso = ['grupo' => 'curso', 'grupoTitulo' => 'Identificação do curso'];
        $familia = ['grupo' => 'familia', 'grupoTitulo' => 'Informações Familiares'];
        $historia = ['grupo' => 'historia', 'grupoTitulo' => 'História Escolar do Estudante'];
        $desenvolvimento = ['grupo' => 'desenvolvimento', 'grupoTitulo' => 'Desenvolvimento biopsicosocial'];
        $comportamento = ['grupo' => 'comportamento', 'grupoTitulo' => 'Características de comportamento do Estudante'];
        $gerais = ['grupo' => 'gerais', 'grupoTitulo' => 'Informações Gerais e de âmbito escolar'];
        $escolaAnterior = ['grupo' => 'escolaAnterior', 'grupoTitulo' => 'Caso haja contato com a escola anterior', 'semNumero' => true];
        $profissionais = ['grupo' => 'profissionais', 'grupoTitulo' => 'Caso haja contato com profissionais externos', 'semNumero' => true];

        return [
            self::campo('nomeCompleto', 'Nome completo do estudante', 'text', [...$identificacao, 'tamanho' => 'large', 'separador' => true, 'max' => 255]),
            self::campo('nomeSocial', 'Nome social', 'text', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),
            self::campo('idade', 'Idade', 'number', [...$identificacao, 'tamanho' => 'small', 'separador' => true, 'regra' => 'integer', 'min' => 0, 'max' => 140]),
            self::campo('dataNascimento', 'Dia de nascimento', 'date', [...$identificacao, 'tamanho' => 'small', 'rotuloFormulario' => 'Data de nascimento']),
            self::campo('podeSerChamadoSAMU', 'Pode ser chamado SAMU?', 'select', [...$identificacao, 'tamanho' => 'small', 'separador' => true, 'opcoes' => $simNao]),
            self::campo('nomeMae', 'Nome completo da mãe', 'text', [...$identificacao, 'tamanho' => 'large', 'separador' => true, 'max' => 255]),
            self::campo('nomePai', 'Nome completo do pai', 'text', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),
            self::campo('nomeResponsavel', 'Nome completo da responsável', 'text', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),
            self::campo('celularEstudante', 'Celular do estudante', 'tel', [...$identificacao, 'tamanho' => 'small', 'separador' => true, 'max' => 50]),
            self::campo('celularMae', 'Celular da mãe', 'tel', [...$identificacao, 'tamanho' => 'small', 'max' => 50]),
            self::campo('celularPai', 'Celular do pai', 'tel', [...$identificacao, 'tamanho' => 'small', 'max' => 50]),
            self::campo('celularFixo', 'Celular fixo', 'tel', [...$identificacao, 'tamanho' => 'small', 'max' => 50]),
            self::campo('emailEstudante', 'Email do estudante', 'email', [...$identificacao, 'tamanho' => 'large', 'separador' => true, 'max' => 255]),
            self::campo('emailMae', 'Email da mãe', 'email', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),
            self::campo('emailPai', 'Email do pai', 'email', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),
            self::campo('emailResponsavel', 'Email do responsável', 'email', [...$identificacao, 'tamanho' => 'large', 'max' => 255]),

            self::campo('nomeCurso', 'Nome do curso', 'text', [...$curso, 'tamanho' => 'large', 'max' => 255]),
            self::campo('formaOferta', 'Forma de oferta', 'select', [...$curso, 'opcoes' => ['FIC' => 'FIC', 'Proeja' => 'Proeja', 'Integrado' => 'Integrado', 'Subsequente' => 'Subsequente', 'Graduação - Licenciatura' => 'Graduação - Licenciatura', 'Graduação - Bacharelado' => 'Graduação - Bacharelado', 'Graduação - Tecnólogo' => 'Graduação - Tecnólogo', 'Especialização' => 'Especialização', 'Mestrado' => 'Mestrado']]),
            self::campo('cota', 'Cota', 'select', [...$curso, 'opcoes' => ['PNE' => 'PNE', 'Pretos ou Pardos' => 'Pretos ou Pardos', 'Indígenas' => 'Indígenas', 'Entrada por sorteio público' => 'Entrada por sorteio público', 'Social' => 'Social', 'Escola Pública' => 'Escola Pública', 'Ampla Concorrência' => 'Ampla Concorrência', 'Quilombola' => 'Quilombola']]),
            self::campo('matricula', 'Matrícula', 'text', [...$curso, 'tamanho' => 'small', 'rotuloFormulario' => 'Matricula', 'max' => 50]),
            self::campo('turno', 'Turno', 'select', [...$curso, 'tamanho' => 'small', 'opcoes' => ['Matutino' => 'Matutino', 'Vespertino' => 'Vespertino', 'Noturno' => 'Noturno']]),
            self::campo('anoPeriodo', 'Ano/Período', 'text', [...$curso, 'tamanho' => 'small', 'max' => 50]),

            self::campo('formacaoMae', 'Formação da mãe', 'text', [...$familia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('profissaoMae', 'Profissão da mãe', 'text', [...$familia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('idadeMae', 'Idade da mãe', 'number', [...$familia, 'tamanho' => 'small', 'regra' => 'integer', 'min' => 0, 'max' => 140]),
            self::campo('maeEmpregada', 'A mãe está atualmente empregada?', 'text', [...$familia, 'max' => 255]),
            self::campo('formacaoPai', 'Formação do pai', 'text', [...$familia, 'tamanho' => 'large', 'separador' => true, 'max' => 255]),
            self::campo('profissaoPai', 'Profissão do pai', 'text', [...$familia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('idadePai', 'Idade do pai', 'number', [...$familia, 'tamanho' => 'small', 'regra' => 'integer', 'min' => 0, 'max' => 140]),
            self::campo('paiEmpregado', 'O pai está atualmente empregado?', 'text', [...$familia, 'max' => 255]),
            self::campo('formacaoResponsavel', 'Formação do responsável', 'text', [...$familia, 'tamanho' => 'large', 'separador' => true, 'max' => 255]),
            self::campo('profissaoResponsavel', 'Profissão do responsável', 'text', [...$familia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('idadeResponsavel', 'Idade do responsável', 'number', [...$familia, 'tamanho' => 'small', 'regra' => 'integer', 'min' => 0, 'max' => 140]),
            self::campo('responsavelEmpregado', 'O responsável está atualmente empregado?', 'text', [...$familia, 'max' => 255]),
            self::campo('numeroIrmaos', 'Número de irmãos', 'text', [...$familia, 'tamanho' => 'small', 'separador' => true, 'max' => 50]),
            self::campo('moraCom', 'Estudante mora com', 'text', [...$familia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('paisSeparados', 'Pais separados?', 'select', [...$familia, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('deficiencia', 'Alguma pessoa da família tem deficiência?', 'select', [...$familia, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('tipoDeficiencia', 'Se sim, qual?', 'text', [...$familia, 'tamanho' => 'large']),
            self::campo('rotinaDiaria', 'Rotina diária antes e depois das aulas/atividades domésticas', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('relacionamentoFamiliares', 'Relacionamento com familiares', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('comQuemConvive', 'Com quem mais convive fora da escola?', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('mantemAmizades', 'Mantém amizades com pessoas da mesma idade', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('atividadesLazer', 'A família se reúne para atividades de lazer? Que tipo?', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('condicoesMoradia', 'Condições de moradia (casa própria, alugada, outro)', 'text', [...$familia, 'tamanho' => 'large']),
            self::campo('ambienteEstudo', 'Tem ambiente específico para estudo? Como é?', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('acompanhamento', 'Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?', 'text', [...$familia, 'tamanho' => 'full']),
            self::campo('localPermanencia', 'Qual é o local da casa onde o estudante permanece mais tempo?', 'text', [...$familia, 'tamanho' => 'large']),

            self::campo('escolaOrigem', 'Qual a escola de origem?', 'text', [...$historia, 'tamanho' => 'large', 'max' => 255]),
            self::campo('tempoIFPR', 'Há quanto tempo no IFPR?', 'text', [...$historia, 'max' => 100]),
            self::campo('reprovacao', 'Já reprovou algum ano escolar? Qual? Motivo?', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('areasFacilidade', 'Áreas de conhecimento com as quais têm mais facilidade na escola', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('areasDificuldade', 'Áreas de conhecimento com as quais têm mais dificuldade na escola', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('trajetoriaEscolar', 'Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes)', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('frequentouEducacaoInfantil', 'Frequentou educação infantil a partir de que idade?', 'text', [...$historia, 'tamanho' => 'large']),
            self::campo('aprendeuLerEscrever', 'Com quantos anos aprendeu a ler e escrever?', 'text', [...$historia, 'tamanho' => 'large']),
            self::campo('cursosExtraEscolares', 'Quais os cursos extra-escolares que já fez?', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('atendimentoEduacionalEspecializado', 'Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('adaptacaoCurricular', 'Foi necessária alguma Adaptação Curricular? Qual(is)?', 'text', [...$historia, 'tamanho' => 'full']),
            self::campo('outrasNecessidades', 'Outras necessidades relatadas e/ou percebidas', 'text', [...$historia, 'tamanho' => 'full', 'rotuloFormulario' => 'Outras necessidades relatadas e/ou percebidas:']),
            self::campo('potencialidades', 'Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela.', 'text', [...$historia, 'tamanho' => 'full']),

            self::campo('gestacaoPlanejada', 'Gestação planejada/desejada', 'text', [...$desenvolvimento, 'tamanho' => 'large']),
            self::campo('fezPreNatal', 'Fez pré-natal?', 'select', [...$desenvolvimento, 'tamanho' => 'small', 'rotuloFormulario' => 'Fez pré-natal', 'opcoes' => $simNao]),
            self::campo('doencasApresentadas', 'Doenças apresentadas?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Doenças apresentadas']),
            self::campo('usouFraldas', 'Usou fraldas até que idade?', 'text', $desenvolvimento),
            self::campo('ateQueIdadeMamadeira', 'Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?', 'text', [...$desenvolvimento, 'tamanho' => 'large']),
            self::campo('desenvolvimentoFalaAndar', 'Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)']),
            self::campo('IndicacoesVacinacao', 'As indicações de vacinação foram cumpridas? Se não, por quê?', 'text', [...$desenvolvimento, 'tamanho' => 'full']),
            self::campo('fazUsoMedicamento', 'Faz uso de medicamento?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Faz uso de medicamento']),
            self::campo('seletividadeRestricaoAlimentar', 'Seletividade ou restrição alimentar?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Seletividade ou restrição alimentar']),
            self::campo('internamentosCirurgias', 'Internamentos e cirurgias?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Internamentos e cirurgias']),
            self::campo('deficienciaTranstornos', 'Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)']),
            self::campo('acompanhamentoSaudeExterno', 'Fez ou faz algum acompanhamento com profissional de Saúde externo?', 'text', [...$desenvolvimento, 'tamanho' => 'full']),
            self::campo('nomeFisioterapeuta', 'Nome do fisioterapeuta?', 'text', [...$desenvolvimento, 'tamanho' => 'large', 'rotuloFormulario' => 'Nome do fisioterapeuta', 'max' => 255]),
            self::campo('contatoFisioterapeuta', 'Contato do fisioterapeuta?', 'text', [...$desenvolvimento, 'rotuloFormulario' => 'Contato do fisioterapeuta', 'max' => 50]),
            self::campo('nomeFonoaudiologo', 'Nome do fonoaudiólogo?', 'text', [...$desenvolvimento, 'tamanho' => 'large', 'rotuloFormulario' => 'Nome do fonoaudiólogo', 'max' => 255]),
            self::campo('contatoFonoaudiologo', 'Contato do fonoaudiólogo?', 'text', [...$desenvolvimento, 'rotuloFormulario' => 'Contato do fonoaudiólogo', 'max' => 50]),
            self::campo('nomePsicologo', 'Nome do psicólogo?', 'text', [...$desenvolvimento, 'tamanho' => 'large', 'rotuloFormulario' => 'Nome do psicólogo', 'max' => 255]),
            self::campo('contatoPsicologo', 'Contato do psicólogo?', 'text', [...$desenvolvimento, 'rotuloFormulario' => 'Contato do psicólogo', 'max' => 50]),
            self::campo('nomeNeurologista', 'Nome do neurologista?', 'text', [...$desenvolvimento, 'tamanho' => 'large', 'rotuloFormulario' => 'Nome do neurologista', 'max' => 255]),
            self::campo('contatoNeurologista', 'Contato do neurologista?', 'text', [...$desenvolvimento, 'rotuloFormulario' => 'Contato do neurologista', 'max' => 50]),
            self::campo('observacoes', 'Observações?', 'text', [...$desenvolvimento, 'tamanho' => 'full', 'rotuloFormulario' => 'Observações']),

            self::campo('timido', 'Timido?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('extrovertido', 'Extrovertido?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('persistente', 'Persistente?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('calmo', 'Calmo?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('agitado', 'Agitado?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('ansioso', 'Ansioso?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('organizado', 'Organizado?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('perfeccionista', 'Perfeccionista?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('responsavel', 'Responsável?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('amoroso', 'Amoroso?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('nervoso', 'Nervoso?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('inseguro', 'Inseguro?', 'select', [...$comportamento, 'tamanho' => 'small', 'opcoes' => $simNao]),
            self::campo('outros', 'Outros?', 'text', [...$comportamento, 'tamanho' => 'full', 'rotuloFormulario' => 'Outros']),

            self::campo('origemHistorico', 'Origem e histórico do caso e dos atendimentos', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('artefatosMobilidade', 'Faz uso de algum artefato para mobilidade? Qual(is)?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('adaptacaoMobiliario', 'Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('necessidadeLocacao', 'É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('adaptacaoComputador', 'Necessita de alguma adaptação para a utilização do computador? Qual?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('transporteCampus', 'Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('atendimentoEducativo', 'Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('necessidadeAdaptacaoCurricular', 'Foi necessária alguma Adaptação Curricular? Qual(is)?', 'text', [...$gerais, 'tamanho' => 'full']),
            self::campo('sistemaLinguistico', 'Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros)', 'text', [...$gerais, 'tamanho' => 'large']),
            self::campo('recursosAcessibilidade', 'Recursos ou equipamentos de acessibilidade já usados pelo estudante', 'text', [...$gerais, 'tamanho' => 'full', 'rotuloFormulario' => 'Recursos ou equipamentos de acessibilidade já usados pelo estudante:']),
            self::campo('recursosProvidenciados', 'Recursos ou equipamentos que necessitam ser providenciados', 'text', [...$gerais, 'tamanho' => 'full', 'rotuloFormulario' => 'Recursos ou equipamentos que necessitam ser providenciados:']),
            self::campo('outrasNecessidadesEscolares', 'Outras necessidades relatadas e/ou percebidas', 'text', [...$gerais, 'tamanho' => 'full', 'rotuloFormulario' => 'Outras necessidades relatadas e/ou percebidas:']),
            self::campo('sugestoesAdaptacao', 'Sugestões para melhoria da adaptação', 'text', [...$gerais, 'tamanho' => 'full']),

            self::campo('acompanhamentoAEE', 'Teve acompanhamento de AEE? Fez uso da sala de recurso?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('potencialidadesDificuldades', 'Potencialidades e dificuldades acadêmicas', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('materialAdaptado', 'Tinha material adaptado? Quais?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('apoioEscolar', 'Participou de apoio escolar? Qual?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('comportamentoDiferenciado', 'Algum comportamento diferenciado?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('questaoSensibilidade', 'Alguma questão de sensibilidade?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('momentoCrise', 'Algum momento de crise? Que tipo?', 'text', [...$escolaAnterior, 'tamanho' => 'full']),
            self::campo('laudoEscola', 'Teve laudo por encaminhamento da escola?', 'text', [...$escolaAnterior, 'tamanho' => 'large']),

            self::campo('inicioTratamento', 'Quando começou o tratamento?', 'text', [...$profissionais, 'tamanho' => 'large']),
            self::campo('porQueComecou', 'Por que começou?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('apresentaCrisesComportamento', 'Apresenta crises de comportamento?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('qualSituacoesDesencadeiamCrises', 'Qual ou quais situações desencadeiam crises?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('orientacoesEvitarEstresse', 'Orientações para evitar estresse', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('quaisMelhorias', 'Quais as melhorias?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('maioresOrientacoes', 'Maiores orientações para sala de aula e escola', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('necessitaAbafadorSom', 'Necessita de abafador de som no ambiente escolar?', 'text', $profissionais),
            self::campo('comoSeOrganiza', 'Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('comoAprende', 'Como o estudante aprende?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('quaisRecursosFacilitam', 'Quais recursos e/ou estratégias facilitam sua aprendizagem?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('quaisRecursosDificultam', 'Quais recursos e/ou estratégias dificultam sua aprendizagem?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('emQueAreaFacilidade', 'Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?', 'text', [...$profissionais, 'tamanho' => 'full']),
            self::campo('emQueAreaDificuldade', 'Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?', 'text', [...$profissionais, 'tamanho' => 'full']),
        ];
    }
}
