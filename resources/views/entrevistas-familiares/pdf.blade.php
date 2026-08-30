@props(['entrevistaFamiliar' => null])

@php
    $campos = $entrevistaFamiliar->campos ?? [];
@endphp

<x-layouts.pdf>
    <p class="text-center mb-lg bold">ENTREVISTA ESCOLAR FAMILIAR</p>

    <p class="mb-md">
        <b>Data da entrevista:</b> {{ $entrevistaFamiliar->data->format('d/m/Y') }}
        <b>Responsável pelo preenchimento:</b> {{ $entrevistaFamiliar->estudante->nome }}<br>
    </p>

    <table class="table">
        <tr><td class="bold">1. Identificação do Estudante</td></tr>
        <tr><td><b>Nome completo do estudante:</b> {{ $campos['nomeCompleto'] ?? '---' }}</td></tr>
        <tr><td><b>Nome social:</b> {{ $campos['nomeSocial'] ?? '---' }}</td></tr>
        <tr><td><b>Idade:</b> {{ $campos['idade'] ?? '---' }} | <b>Dia de nascimento:</b> {{ $campos['dataNascimento'] ?? '---' }}</td></tr>
        <tr><td><b>Nome completo da mãe:</b> {{ $campos['nomeMae'] ?? '---' }}</td></tr>
        <tr><td><b>Nome completo do pai:</b> {{ $campos['nomePai'] ?? '---' }}</td></tr>
        <tr><td><b>Nome completo do responsável:</b> {{ $campos['nomeResponsavel'] ?? '---' }}</td></tr>
        <tr><td><b>Celular (Estudante / Mãe / Pai / Fixo):</b> {{ $campos['celularEstudante'] ?? '---' }} / {{ $campos['celularMae'] ?? '---' }} / {{ $campos['celularPai'] ?? '---' }} / {{ $campos['celularFixo'] ?? '---' }}</td></tr>
        <tr><td><b>E-mail (Estudante / Mãe / Pai / Responsável):</b> {{ $campos['emailEstudante'] ?? '---' }} / {{ $campos['emailMae'] ?? '---' }} / {{ $campos['emailPai'] ?? '---' }} / {{ $campos['emailResponsavel'] ?? '---' }}</td></tr>
        <tr><td><b>Pode ser chamado SAMU?:</b> {{ $campos['podeSerChamadoSAMU'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">2. Identificação do curso</td></tr>
        <tr><td><b>Nome do curso:</b> {{ $campos['nomeCurso'] ?? '---' }}</td></tr>
        <tr><td><b>Forma de oferta:</b> {{ $campos['formaOferta'] ?? '---' }} | <b>Matrícula:</b> {{ $campos['matricula'] ?? '---' }}</td></tr>
        <tr><td><b>Turno:</b> {{ $campos['turno'] ?? '---' }} | <b>Ano/Período:</b> {{ $campos['anoPeriodo'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">3. Cota de Ingresso</td></tr>
        <tr><td><b>Cota:</b> {{ $campos['cota'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">4. Informações Familiares</td></tr>
        <tr><td><b>Formação da mãe:</b> {{ $campos['formacaoMae'] ?? '---' }} | <b>Profissão:</b> {{ $campos['profissaoMae'] ?? '---' }} | <b>Idade:</b> {{ $campos['idadeMae'] ?? '---' }} | <b>Empregada?:</b> {{ $campos['maeEmpregada'] ?? '---' }}</td></tr>
        <tr><td><b>Formação do pai:</b> {{ $campos['formacaoPai'] ?? '---' }} | <b>Profissão:</b> {{ $campos['profissaoPai'] ?? '---' }} | <b>Idade:</b> {{ $campos['idadePai'] ?? '---' }} | <b>Empregado?:</b> {{ $campos['paiEmpregado'] ?? '---' }}</td></tr>
        <tr><td><b>Formação do responsável:</b> {{ $campos['formacaoResponsavel'] ?? '---' }} | <b>Profissão:</b> {{ $campos['profissaoResponsavel'] ?? '---' }} | <b>Idade:</b> {{ $campos['idadeResponsavel'] ?? '---' }} | <b>Empregado?:</b> {{ $campos['responsavelEmpregado'] ?? '---' }}</td></tr>
        <tr><td><b>Número de irmãos:</b> {{ $campos['numeroIrmaos'] ?? '---' }} | <b>Mora com:</b> {{ $campos['moraCom'] ?? '---' }} | <b>Pais separados?:</b> {{ $campos['paisSeparados'] ?? '---' }}</td></tr>
        <tr><td><b>Deficiência na família?:</b> {{ $campos['deficiencia'] ?? '---' }} (<b>Qual?:</b> {{ $campos['tipoDeficiencia'] ?? '---' }})</td></tr>
        <tr><td class="textarea"><b>Rotina diária e atividades domésticas:</b> {{ $campos['rotinaDiaria'] ?? '---' }}</td></tr>
        <tr><td><b>Relacionamento com familiares:</b> {{ $campos['relacionamentoFamiliares'] ?? '---' }}</td></tr>
        <tr><td><b>Com quem mais convive fora da escola?:</b> {{ $campos['comQuemConvive'] ?? '---' }} | <b>Mantém amizades:</b> {{ $campos['mantemAmizades'] ?? '---' }}</td></tr>
        <tr><td><b>Atividades de lazer em família:</b> {{ $campos['atividadesLazer'] ?? '---' }}</td></tr>
        <tr><td><b>Condições de moradia:</b> {{ $campos['condicoesMoradia'] ?? '---' }}</td></tr>
        <tr><td><b>Ambiente específico para estudo:</b> {{ $campos['ambienteEstudo'] ?? '---' }}</td></tr>
        <tr><td><b>Acompanhamento de acesso (computador/celular):</b> {{ $campos['acompanhamento'] ?? '---' }}</td></tr>
        <tr><td><b>Local da casa onde permanece mais tempo:</b> {{ $campos['localPermanencia'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">5. História Escolar do Estudante</td></tr>
        <tr><td><b>Escola de origem:</b> {{ $campos['escolaOrigem'] ?? '---' }} | <b>Tempo no IFPR:</b> {{ $campos['tempoIFPR'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Reprovação escolar (Qual/Motivo):</b> {{ $campos['reprovacao'] ?? '---' }}</td></tr>
        <tr><td><b>Áreas com facilidade:</b> {{ $campos['areasFacilidade'] ?? '---' }}</td></tr>
        <tr><td><b>Áreas com dificuldade:</b> {{ $campos['areasDificuldade'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Trajetória escolar:</b> {{ $campos['trajetoriaEscolar'] ?? '---' }}</td></tr>
        <tr><td><b>Educação infantil a partir de:</b> {{ $campos['frequentouEducacaoInfantil'] ?? '---' }} | <b>Idade que aprendeu a ler/escrever:</b> {{ $campos['aprendeuLerEscrever'] ?? '---' }}</td></tr>
        <tr><td><b>Cursos extra-escolares:</b> {{ $campos['cursosExtraEscolares'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Atendimento educacional especializado anterior:</b> {{ $campos['atendimentoEduacionalEspecializado'] ?? '---' }}</td></tr>
        <tr><td><b>Adaptação curricular necessária:</b> {{ $campos['adaptacaoCurricular'] ?? '---' }}</td></tr>
        <tr><td><b>Outras necessidades relatadas:</b> {{ $campos['outrasNecessidades'] ?? '---' }}</td></tr>
        <tr><td><b>Potencialidades do estudante:</b> {{ $campos['potencialidades'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">6. Desenvolvimento Biopsicossocial</td></tr>
        <tr><td><b>Gestação planejada:</b> {{ $campos['gestacaoPlanejada'] ?? '---' }} | <b>Pré-natal?:</b> {{ $campos['fezPreNatal'] ?? '---' }} | <b>Doenças:</b> {{ $campos['doencasApresentadas'] ?? '---' }}</td></tr>
        <tr><td><b>Uso de fraldas até:</b> {{ $campos['usouFraldas'] ?? '---' }} | <b>Mamadeira/chupeta até:</b> {{ $campos['ateQueIdadeMamadeira'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Desenvolvimento da fala, andar e alimentação:</b> {{ $campos['desenvolvimentoFalaAndar'] ?? '---' }}</td></tr>
        <tr><td><b>Vacinação em dia?:</b> {{ $campos['IndicacoesVacinacao'] ?? '---' }} | <b>Uso de medicamento?:</b> {{ $campos['fazUsoMedicamento'] ?? '---' }}</td></tr>
        <tr><td><b>Seletividade ou restrição alimentar:</b> {{ $campos['seletividadeRestricaoAlimentar'] ?? '---' }}</td></tr>
        <tr><td><b>Internamentos e cirurgias:</b> {{ $campos['internamentosCirurgias'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Deficiência, Transtorno ou Altas Habilidades:</b> {{ $campos['deficienciaTranstornos'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Acompanhamento de saúde externo:</b> {{ $campos['acompanhamentoSaudeExterno'] ?? '---' }}</td></tr>
        <tr><td><b>Fisioterapeuta:</b> {{ $campos['nomeFisioterapeuta'] ?? '---' }} | <b>Contato:</b> {{ $campos['contatoFisioterapeuta'] ?? '---' }}</td></tr>
        <tr><td><b>Fonoaudiólogo:</b> {{ $campos['nomeFonoaudiologo'] ?? '---' }} | <b>Contato:</b> {{ $campos['contatoFonoaudiologo'] ?? '---' }}</td></tr>
        <tr><td><b>Psicólogo:</b> {{ $campos['nomePsicologo'] ?? '---' }} | <b>Contato:</b> {{ $campos['contatoPsicologo'] ?? '---' }}</td></tr>
        <tr><td><b>Neurologista:</b> {{ $campos['nomeNeurologista'] ?? '---' }} | <b>Contato:</b> {{ $campos['contatoNeurologista'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Observações:</b> {{ $campos['observacoes'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">7. Características de Comportamento do Estudante</td></tr>
        <tr><td><b>Tímido:</b> {{ $campos['timido'] ?? '---' }} | <b>Extrovertido:</b> {{ $campos['extrovertido'] ?? '---' }} | <b>Persistente:</b> {{ $campos['persistente'] ?? '---' }}</td></tr>
        <tr><td><b>Calmo:</b> {{ $campos['calmo'] ?? '---' }} | <b>Agitado:</b> {{ $campos['agitado'] ?? '---' }} | <b>Ansioso:</b> {{ $campos['ansioso'] ?? '---' }}</td></tr>
        <tr><td><b>Organizado:</b> {{ $campos['organizado'] ?? '---' }} | <b>Perfeccionista:</b> {{ $campos['perfeccionista'] ?? '---' }} | <b>Responsável:</b> {{ $campos['responsavel'] ?? '---' }}</td></tr>
        <tr><td><b>Amoroso:</b> {{ $campos['amoroso'] ?? '---' }} | <b>Nervoso:</b> {{ $campos['nervoso'] ?? '---' }} | <b>Inseguro:</b> {{ $campos['inseguro'] ?? '---' }}</td></tr>
        <tr><td><b>Outros:</b> {{ $campos['outros'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">8. Informações Gerais e de Âmbito Escolar</td></tr>
        <tr><td class="textarea"><b>Origem e histórico do caso:</b> {{ $campos['origemHistorico'] ?? '---' }}</td></tr>
        <tr><td><b>Artefatos para mobilidade:</b> {{ $campos['artefatosMobilidade'] ?? '---' }}</td></tr>
        <tr><td><b>Necessidade de adaptação de mobiliário:</b> {{ $campos['adaptacaoMobiliario'] ?? '---' }}</td></tr>
        <tr><td><b>Dependência para locomoção (rampas, banheiros):</b> {{ $campos['necessidadeLocacao'] ?? '---' }}</td></tr>
        <tr><td><b>Adaptação para computador:</b> {{ $campos['adaptacaoComputador'] ?? '---' }}</td></tr>
        <tr><td><b>Transporte e auxílio para ingresso ao Campus:</b> {{ $campos['transporteCampus'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Atendimento educacional especializado:</b> {{ $campos['atendimentoEducativo'] ?? '---' }}</td></tr>
        <tr><td><b>Adaptação curricular:</b> {{ $campos['necessidadeAdaptacaoCurricular'] ?? '---' }}</td></tr>
        <tr><td><b>Sistema linguístico utilizado:</b> {{ $campos['sistemaLinguistico'] ?? '---' }}</td></tr>
        <tr><td><b>Recursos de acessibilidade usados:</b> {{ $campos['recursosAcessibilidade'] ?? '---' }}</td></tr>
        <tr><td><b>Recursos a providenciar:</b> {{ $campos['recursosProvidenciados'] ?? '---' }}</td></tr>
        <tr><td><b>Outras necessidades escolares:</b> {{ $campos['outrasNecessidadesEscolares'] ?? '---' }}</td></tr>
        <tr><td><b>Sugestões para melhoria da adaptação:</b> {{ $campos['sugestoesAdaptacao'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">Caso haja contato com a escola anterior</td></tr>
        <tr><td><b>Acompanhamento de AEE / Sala de recurso:</b> {{ $campos['acompanhamentoAEE'] ?? '---' }}</td></tr>
        <tr><td><b>Potencialidades e dificuldades acadêmicas:</b> {{ $campos['potencialidadesDificuldades'] ?? '---' }}</td></tr>
        <tr><td><b>Material adaptado:</b> {{ $campos['materialAdaptado'] ?? '---' }}</td></tr>
        <tr><td><b>Apoio escolar:</b> {{ $campos['apoioEscolar'] ?? '---' }}</td></tr>
        <tr><td><b>Comportamento diferenciado:</b> {{ $campos['comportamentoDiferenciado'] ?? '---' }}</td></tr>
        <tr><td><b>Questão de sensibilidade:</b> {{ $campos['questaoSensibilidade'] ?? '---' }}</td></tr>
        <tr><td><b>Momento de crise:</b> {{ $campos['momentoCrise'] ?? '---' }}</td></tr>
        <tr><td><b>Laudo por encaminhamento da escola:</b> {{ $campos['laudoEscola'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td class="bold">Caso haja contato com profissionais externos</td></tr>
        <tr><td><b>Quando começou o tratamento:</b> {{ $campos['inicioTratamento'] ?? '---' }}</td></tr>
        <tr><td><b>Por que começou:</b> {{ $campos['porQueComecou'] ?? '---' }}</td></tr>
        <tr><td><b>Apresenta crises de comportamento:</b> {{ $campos['apresentaCrisesComportamento'] ?? '---' }}</td></tr>
        <tr><td><b>Situações que desencadeiam crises:</b> {{ $campos['qualSituacoesDesencadeiamCrises'] ?? '---' }}</td></tr>
        <tr><td><b>Orientações para evitar estresse:</b> {{ $campos['orientacoesEvitarEstresse'] ?? '---' }}</td></tr>
        <tr><td><b>Quais as melhorias:</b> {{ $campos['quaisMelhorias'] ?? '---' }}</td></tr>
        <tr><td class="textarea"><b>Maiores orientações para sala de aula e escola:</b> {{ $campos['maioresOrientacoes'] ?? '---' }}</td></tr>
        <tr><td><b>Necessita de abafador de som no ambiente escolar?:</b> {{ $campos['necessitaAbafadorSom'] ?? '---' }}</td></tr>
        <tr><td><b>Como o estudante se organiza (agendas):</b> {{ $campos['comoSeOrganiza'] ?? '---' }}</td></tr>
        <tr><td><b>Como o estudante aprende:</b> {{ $campos['comoAprende'] ?? '---' }}</td></tr>
        <tr><td><b>Recursos/estratégias que facilitam:</b> {{ $campos['quaisRecursosFacilitam'] ?? '---' }}</td></tr>
        <tr><td><b>Recursos/estratégias que dificultam:</b> {{ $campos['quaisRecursosDificultam'] ?? '---' }}</td></tr>
        <tr><td><b>Área do conhecimento com mais facilidade (e por quê):</b> {{ $campos['emQueAreaFacilidade'] ?? '---' }}</td></tr>
        <tr><td><b>Área do conhecimento com mais dificuldade (e por quê):</b> {{ $campos['emQueAreaDificuldade'] ?? '---' }}</td></tr>
    </table>
</x-layouts.pdf>
