@props(['entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;
?>

<x-layouts.pdf>
    <p class="text-center mb-lg">ENTREVISTA ESCOLAR FAMILIAR</p>

    <div class="border text-center mb-md bold">
        Entrevista com a Família do Estudante
    </div>

    <p class="mb-md">
        <b>Estudante:</b> {{$entrevistaFamiliar->estudante->nome }}<br>
        <b>Data da entrevista:</b> {{$entrevistaFamiliar->data->format('d/m/Y')}}
    </p>

    <!-- 1. Identificação do Estudante -->
    <table class="table">
        <tr>
            <td class="bold">1. Identificação do Estudante</td>
        </tr>
        <tr>
            <td><b>Nome completo do estudante:</b> {{$entrevistaFamiliar->campos['nomeCompleto']}}</td>
        </tr>
        <tr>
            <td><b>Nome social:</b> {{$entrevistaFamiliar->campos['nomeSocial']}}</td>
        </tr>
        <tr>
            <td><b>Idade:</b> {{$entrevistaFamiliar->campos['idade']}} | <b>Dia de nascimento:</b> {{$entrevistaFamiliar->campos['dataNascimento']}}</td>
        </tr>
        <tr>
            <td><b>Nome completo da mãe:</b> {{$entrevistaFamiliar->campos['nomeMae']}}</td>
        </tr>
        <tr>
            <td><b>Nome completo do pai:</b> {{$entrevistaFamiliar->campos['nomePai']}}</td>
        </tr>
        <tr>
            <td><b>Nome completo do responsável:</b> {{$entrevistaFamiliar->campos['nomeResponsavel']}}</td>
        </tr>
        <tr>
            <td><b>Celular (Estudante / Mãe / Pai / Fixo):</b> {{$entrevistaFamiliar->campos['celularEstudante']}} / {{$entrevistaFamiliar->campos['celularMae']}} / {{$entrevistaFamiliar->campos['celularPai']}} / {{$entrevistaFamiliar->campos['celularFixo']}}</td>
        </tr>
        <tr>
            <td><b>E-mail (Estudante / Mãe / Pai / Responsável):</b> {{$entrevistaFamiliar->campos['emailEstudante']}} / {{$entrevistaFamiliar->campos['emailMae']}} / {{$entrevistaFamiliar->campos['emailPai']}} / {{$entrevistaFamiliar->campos['emailResponsavel']}}</td>
        </tr>
        <tr>
            <td><b>Pode ser chamado SAMU?:</b> {{$entrevistaFamiliar->campos['podeSerChamadoSAMU']}}</td>
        </tr>
    </table>

    <!-- 2. Identificação do curso -->
    <table class="table">
        <tr>
            <td class="bold">2. Identificação do curso</td>
        </tr>
        <tr>
            <td><b>Nome do curso:</b> {{$entrevistaFamiliar->campos['nomeCurso']}}</td>
        </tr>
        <tr>
            <td><b>Forma de oferta:</b> {{$entrevistaFamiliar->campos['formaOferta']}} | <b>Matrícula:</b> {{$entrevistaFamiliar->campos['matricula']}}</td>
        </tr>
        <tr>
            <td><b>Turno:</b> {{$entrevistaFamiliar->campos['turno']}} | <b>Ano/Período:</b> {{$entrevistaFamiliar->campos['anoPeriodo']}}</td>
        </tr>
    </table>

    <!-- 3. Cota de Ingresso -->
    <table class="table">
        <tr>
            <td class="bold">3. Cota de Ingresso</td>
        </tr>
        <tr>
            <td><b>Cota:</b> {{$entrevistaFamiliar->campos['cota']}}</td>
        </tr>
    </table>

    <!-- 4. Informações Familiares -->
    <table class="table">
        <tr>
            <td class="bold">4. Informações Familiares</td>
        </tr>
        <tr>
            <td><b>Formação da mãe:</b> {{$entrevistaFamiliar->campos['formacaoMae']}} | <b>Profissão:</b> {{$entrevistaFamiliar->campos['profissaoMae']}} | <b>Idade:</b> {{$entrevistaFamiliar->campos['idadeMae']}} | <b>Empregada?:</b> {{$entrevistaFamiliar->campos['maeEmpregada']}}</td>
        </tr>
        <tr>
            <td><b>Formação do pai:</b> {{$entrevistaFamiliar->campos['formacaoPai']}} | <b>Profissão:</b> {{$entrevistaFamiliar->campos['profissaoPai']}} | <b>Idade:</b> {{$entrevistaFamiliar->campos['idadePai']}} | <b>Empregado?:</b> {{$entrevistaFamiliar->campos['paiEmpregado']}}</td>
        </tr>
        <tr>
            <td><b>Formação do responsável:</b> {{$entrevistaFamiliar->campos['formacaoResponsavel']}} | <b>Profissão:</b> {{$entrevistaFamiliar->campos['profissaoResponsavel']}} | <b>Idade:</b> {{$entrevistaFamiliar->campos['idadeResponsavel']}} | <b>Empregado?:</b> {{$entrevistaFamiliar->campos['responsavelEmpregado']}}</td>
        </tr>
        <tr>
            <td><b>Número de irmãos:</b> {{$entrevistaFamiliar->campos['numeroIrmaos']}} | <b>Mora com:</b> {{$entrevistaFamiliar->campos['moraCom']}} | <b>Pais separados?:</b> {{$entrevistaFamiliar->campos['paisSeparados']}}</td>
        </tr>
        <tr>
            <td><b>Deficiência na família?:</b> {{$entrevistaFamiliar->campos['deficiencia']}} (<b>Qual?:</b> {{$entrevistaFamiliar->campos['tipoDeficiencia']}})</td>
        </tr>
        <tr>
            <td class="textarea"><b>Rotina diária e atividades domésticas:</b> {{$entrevistaFamiliar->campos['rotinaDiaria']}}</td>
        </tr>
        <tr>
            <td><b>Relacionamento com familiares:</b> {{$entrevistaFamiliar->campos['relacionamentoFamiliares']}}</td>
        </tr>
        <tr>
            <td><b>Com quem mais convive fora da escola?:</b> {{$entrevistaFamiliar->campos['comQuemConvive']}} | <b>Mantém amizades:</b> {{$entrevistaFamiliar->campos['mantemAmizades']}}</td>
        </tr>
        <tr>
            <td><b>Atividades de lazer em família:</b> {{$entrevistaFamiliar->campos['atividadesLazer']}}</td>
        </tr>
        <tr>
            <td><b>Condições de moradia:</b> {{$entrevistaFamiliar->campos['condicoesMoradia']}}</td>
        </tr>
        <tr>
            <td><b>Ambiente específico para estudo:</b> {{$entrevistaFamiliar->campos['ambienteEstudo']}}</td>
        </tr>
        <tr>
            <td><b>Acompanhamento de acesso (computador/celular):</b> {{$entrevistaFamiliar->campos['acompanhamento']}}</td>
        </tr>
        <tr>
            <td><b>Local da casa onde permanece mais tempo:</b> {{$entrevistaFamiliar->campos['localPermanencia']}}</td>
        </tr>
    </table>

    <!-- 5. História Escolar do Estudante -->
    <table class="table">
        <tr>
            <td class="bold">5. História Escolar do Estudante</td>
        </tr>
        <tr>
            <td><b>Escola de origem:</b> {{$entrevistaFamiliar->campos['escolaOrigem']}} | <b>Tempo no IFPR:</b> {{$entrevistaFamiliar->campos['tempoIFPR']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Reprovação escolar (Qual/Motivo):</b> {{$entrevistaFamiliar->campos['reprovacao']}}</td>
        </tr>
        <tr>
            <td><b>Áreas com facilidade:</b> {{$entrevistaFamiliar->campos['areasFacilidade']}}</td>
        </tr>
        <tr>
            <td><b>Áreas com dificuldade:</b> {{$entrevistaFamiliar->campos['areasDificuldade']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Trajetória escolar:</b> {{$entrevistaFamiliar->campos['trajetoriaEscolar']}}</td>
        </tr>
        <tr>
            <td><b>Educação infantil a partir de:</b> {{$entrevistaFamiliar->campos['frequentouEducacaoInfantil']}} | <b>Idade que aprendeu a ler/escrever:</b> {{$entrevistaFamiliar->campos['aprendeuLerEscrever']}}</td>
        </tr>
        <tr>
            <td><b>Cursos extra-escolares:</b> {{$entrevistaFamiliar->campos['cursosExtraEscolares']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Atendimento educacional especializado anterior:</b> {{$entrevistaFamiliar->campos['atendimentoEduacionalEspecializado']}}</td>
        </tr>
        <tr>
            <td><b>Adaptação curricular necessária:</b> {{$entrevistaFamiliar->campos['adaptacaoCurricular']}}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades relatadas:</b> {{$entrevistaFamiliar->campos['outrasNecessidades']}}</td>
        </tr>
        <tr>
            <td><b>Potencialidades do estudante:</b> {{$entrevistaFamiliar->campos['potencialidades']}}</td>
        </tr>
    </table>

    <!-- 6. Desenvolvimento biopsicosocial -->
    <table class="table">
        <tr>
            <td class="bold">6. Desenvolvimento Biopsicossocial</td>
        </tr>
        <tr>
            <td><b>Gestação planejada:</b> {{$entrevistaFamiliar->campos['gestacaoPlanejada']}} | <b>Pré-natal?:</b> {{$entrevistaFamiliar->campos['fezPreNatal']}} | <b>Doenças:</b> {{$entrevistaFamiliar->campos['doencasApresentadas']}}</td>
        </tr>
        <tr>
            <td><b>Uso de fraldas até:</b> {{$entrevistaFamiliar->campos['usouFraldas']}} | <b>Mamadeira/chupeta até:</b> {{$entrevistaFamiliar->campos['ateQueIdadeMamadeira']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Desenvolvimento da fala, andar e alimentação:</b> {{$entrevistaFamiliar->campos['desenvolvimentoFalaAndar']}}</td>
        </tr>
        <tr>
            <td><b>Vacinação em dia?:</b> {{$entrevistaFamiliar->campos['IndicacoesVacinacao']}} | <b>Uso de medicamento?:</b> {{$entrevistaFamiliar->campos['fazUsoMedicamento']}}</td>
        </tr>
        <tr>
            <td><b>Seletividade ou restrição alimentar:</b> {{$entrevistaFamiliar->campos['seletividadeRestricaoAlimentar']}}</td>
        </tr>
        <tr>
            <td><b>Internamentos e cirurgias:</b> {{$entrevistaFamiliar->campos['internamentosCirurgias']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Deficiência, Transtorno ou Altas Habilidades:</b> {{$entrevistaFamiliar->campos['deficienciaTranstornos']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Acompanhamento de saúde externo:</b> {{$entrevistaFamiliar->campos['acompanhamentoSaudeExterno']}}</td>
        </tr>
        <tr>
            <td><b>Fisioterapeuta:</b> {{$entrevistaFamiliar->campos['nomeFisioterapeuta']}} | <b>Contato:</b> {{$entrevistaFamiliar->campos['contatoFisioterapeuta']}}</td>
        </tr>
        <tr>
            <td><b>Fonoaudiólogo:</b> {{$entrevistaFamiliar->campos['nomeFonoaudiologo']}} | <b>Contato:</b> {{$entrevistaFamiliar->campos['contatoFonoaudiologo']}}</td>
        </tr>
        <tr>
            <td><b>Psicólogo:</b> {{$entrevistaFamiliar->campos['nomePsicologo']}} | <b>Contato:</b> {{$entrevistaFamiliar->campos['contatoPsicologo']}}</td>
        </tr>
        <tr>
            <td><b>Neurologista:</b> {{$entrevistaFamiliar->campos['nomeNeurologista']}} | <b>Contato:</b> {{$entrevistaFamiliar->campos['contatoNeurologista']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Observações:</b> {{$entrevistaFamiliar->campos['observacoes']}}</td>
        </tr>
    </table>

    <!-- 7. Características de comportamento do Estudante -->
    <table class="table">
        <tr>
            <td class="bold">7. Características de Comportamento do Estudante</td>
        </tr>
        <tr>
            <td>
                <b>Tímido:</b> {{$entrevistaFamiliar->campos['timido']}} | 
                <b>Extrovertido:</b> {{$entrevistaFamiliar->campos['extrovertido']}} | 
                <b>Persistente:</b> {{$entrevistaFamiliar->campos['persistente']}}<br>
                <b>Calmo:</b> {{$entrevistaFamiliar->campos['calmo']}} | 
                <b>Agitado:</b> {{$entrevistaFamiliar->campos['agitado']}} | 
                <b>Ansioso:</b> {{$entrevistaFamiliar->campos['ansioso']}}<br>
                <b>Organizado:</b> {{$entrevistaFamiliar->campos['organizado']}} | 
                <b>Perfeccionista:</b> {{$entrevistaFamiliar->campos['perfeccionista']}} | 
                <b>Responsável:</b> {{$entrevistaFamiliar->campos['responsavel']}}<br>
                <b>Amoroso:</b> {{$entrevistaFamiliar->campos['amoroso']}} | 
                <b>Nervoso:</b> {{$entrevistaFamiliar->campos['nervoso']}} | 
                <b>Inseguro:</b> {{$entrevistaFamiliar->campos['inseguro']}}<br>
                <b>Outros:</b> {{$entrevistaFamiliar->campos['outros']}}
            </td>
        </tr>
    </table>

    <!-- 8. Informações Gerais e de âmbito escolar -->
    <table class="table">
        <tr>
            <td class="bold">8. Informações Gerais e de Âmbito Escolar</td>
        </tr>
        <tr>
            <td class="textarea"><b>Origem e histórico do caso:</b> {{$entrevistaFamiliar->campos['origemHistorico']}}</td>
        </tr>
        <tr>
            <td><b>Artefatos para mobilidade:</b> {{$entrevistaFamiliar->campos['artefatosMobilidade']}}</td>
        </tr>
        <tr>
            <td><b>Necessidade de adaptação de mobiliário:</b> {{$entrevistaFamiliar->campos['adaptacaoMobiliario']}}</td>
        </tr>
        <tr>
            <td><b>Dependência para locomoção (rampas, banheiros):</b> {{$entrevistaFamiliar->campos['necessidadeLocacao']}}</td>
        </tr>
        <tr>
            <td><b>Adaptação para computador:</b> {{$entrevistaFamiliar->campos['adaptacaoComputador']}}</td>
        </tr>
        <tr>
            <td><b>Transporte e auxílio para ingresso ao Campus:</b> {{$entrevistaFamiliar->campos['transporteCampus']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Atendimento educacional especializado:</b> {{$entrevistaFamiliar->campos['atendimentoEducativo']}}</td>
        </tr>
        <tr>
            <td><b>Adaptação curricular:</b> {{$entrevistaFamiliar->campos['necessidadeAdaptacaoCurricular']}}</td>
        </tr>
        <tr>
            <td><b>Sistema linguístico utilizado:</b> {{$entrevistaFamiliar->campos['sistemaLinguistico']}}</td>
        </tr>
        <tr>
            <td><b>Recursos de acessibilidade usados:</b> {{$entrevistaFamiliar->campos['recursosAcessibilidade']}}</td>
        </tr>
        <tr>
            <td><b>Recursos a providenciar:</b> {{$entrevistaFamiliar->campos['recursosProvidenciados']}}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades escolares:</b> {{$entrevistaFamiliar->campos['outrasNecessidadesEscolares']}}</td>
        </tr>
        <tr>
            <td><b>Sugestões para melhoria da adaptação:</b> {{$entrevistaFamiliar->campos['sugestoesAdaptacao']}}</td>
        </tr>
    </table>

    <!-- Caso haja contato com a escola anterior -->
    <table class="table">
        <tr>
            <td class="bold">Caso haja contato com a escola anterior</td>
        </tr>
        <tr>
            <td><b>Acompanhamento de AEE / Sala de recurso:</b> {{$entrevistaFamiliar->campos['acompanhamentoAEE']}}</td>
        </tr>
        <tr>
            <td><b>Potencialidades e dificuldades acadêmicas:</b> {{$entrevistaFamiliar->campos['potencialidadesDificuldades']}}</td>
        </tr>
        <tr>
            <td><b>Material adaptado:</b> {{$entrevistaFamiliar->campos['materialAdaptado']}}</td>
        </tr>
        <tr>
            <td><b>Apoio escolar:</b> {{$entrevistaFamiliar->campos['apoioEscolar']}}</td>
        </tr>
        <tr>
            <td><b>Comportamento diferenciado:</b> {{$entrevistaFamiliar->campos['comportamentoDiferenciado']}}</td>
        </tr>
        <tr>
            <td><b>Questão de sensibilidade:</b> {{$entrevistaFamiliar->campos['questaoSensibilidade']}}</td>
        </tr>
        <tr>
            <td><b>Momento de crise:</b> {{$entrevistaFamiliar->campos['momentoCrise']}}</td>
        </tr>
        <tr>
            <td><b>Laudo por encaminhamento da escola:</b> {{$entrevistaFamiliar->campos['laudoEscola']}}</td>
        </tr>
    </table>

    <!-- Caso haja contato com profissionais externos -->
    <table class="table">
        <tr>
            <td class="bold">Caso haja contato com profissionais externos</td>
        </tr>
        <tr>
            <td><b>Quando começou o tratamento:</b> {{$entrevistaFamiliar->campos['inicioTratamento']}}</td>
        </tr>
        <tr>
            <td><b>Por que começou:</b> {{$entrevistaFamiliar->campos['porQueComecou']}}</td>
        </tr>
        <tr>
            <td><b>Apresenta crises de comportamento:</b> {{$entrevistaFamiliar->campos['apresentaCrisesComportamento']}}</td>
        </tr>
        <tr>
            <td><b>Situações que desencadeiam crises:</b> {{$entrevistaFamiliar->campos['qualSituacoesDesencadeiamCrises']}}</td>
        </tr>
        <tr>
            <td><b>Orientações para evitar estresse:</b> {{$entrevistaFamiliar->campos['orientacoesEvitarEstresse']}}</td>
        </tr>
        <tr>
            <td><b>Quais as melhorias:</b> {{$entrevistaFamiliar->campos['quaisMelhorias']}}</td>
        </tr>
        <tr>
            <td class="textarea"><b>Maiores orientações para sala de aula e escola:</b> {{$entrevistaFamiliar->campos['maioresOrientacoes']}}</td>
        </tr>
        <tr>
            <td><b>Necessita de abafador de som no ambiente escolar?:</b> {{$entrevistaFamiliar->campos['necessitaAbafadorSom']}}</td>
        </tr>
        <tr>
            <td><b>Como o estudante se organiza (agendas):</b> {{$entrevistaFamiliar->campos['comoSeOrganiza']}}</td>
        </tr>
        <tr>
            <td><b>Como o estudante aprende:</b> {{$entrevistaFamiliar->campos['comoAprende']}}</td>
        </tr>
        <tr>
            <td><b>Recursos/estratégias que facilitam:</b> {{$entrevistaFamiliar->campos['quaisRecursosFacilitam']}}</td>
        </tr>
        <tr>
            <td><b>Recursos/estratégias que dificultam:</b> {{$entrevistaFamiliar->campos['quaisRecursosDificultam']}}</td>
        </tr>
        <tr>
            <td><b>Área do conhecimento com mais facilidade (e por quê):</b> {{$entrevistaFamiliar->campos['emQueAreaFacilidade']}}</td>
        </tr>
        <tr>
            <td><b>Área do conhecimento com mais dificuldade (e por quê):</b> {{$entrevistaFamiliar->campos['emQueAreaDificuldade']}}</td>
        </tr>
    </table>
</x-layouts.pdf>