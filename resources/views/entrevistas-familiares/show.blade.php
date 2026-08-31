@props(['entrevistaFamiliar' => null])

@php
    $campos = $entrevistaFamiliar->campos ?? [];
@endphp

<x-layouts.main title="Entrevista Escolar Familiar de {{ $entrevistaFamiliar->estudante->nome }}">
    <div class="flex justify-between items-center mb-5">
        <div class="flex flex-col">
            <p class="text-title-medium">Data da entrevista: {{ $entrevistaFamiliar->data->format('d/m/Y') }}</p>
            <p class="text-title-medium">Responsável pelo preenchimento: {{ $entrevistaFamiliar->responsavel_preenchimento }}</p>
        </div>
        <x-button label="Exportar como PDF" target="_blank" icon="file_export" iconPos="right" color="tertiary" type="link" :href="route('estudantes.entrevistas-familiares.exportPdf', ['entrevistaFamiliar' => $entrevistaFamiliar, 'estudante' => $estudante])" />
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Identificação do Estudante</h2>
        <hr class="text-on-surface">
        <p>Nome completo do estudante: {{ $campos['nomeCompleto'] ?? '---' }}</p>
        <p>Nome social: {{ $campos['nomeSocial'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Idade: {{ $campos['idade'] ?? '---' }}</p>
        <p>Dia de nascimento: {{ $campos['dataNascimento'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Nome completo da mãe: {{ $campos['nomeMae'] ?? '---' }}</p>
        <p>Nome completo do pai: {{ $campos['nomePai'] ?? '---' }}</p>
        <p>Nome completo da responsável: {{ $campos['nomeResponsavel'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Celular do estudante: {{ $campos['celularEstudante'] ?? '---' }}</p>
        <p>Celular da mãe: {{ $campos['celularMae'] ?? '---' }}</p>
        <p>Celular do pai: {{ $campos['celularPai'] ?? '---' }}</p>
        <p>Celular fixo: {{ $campos['celularFixo'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Email do estudante: {{ $campos['emailEstudante'] ?? '---' }}</p>
        <p>Email da mãe: {{ $campos['emailMae'] ?? '---' }}</p>
        <p>Email do pai: {{ $campos['emailPai'] ?? '---' }}</p>
        <p>Email do responsável: {{ $campos['emailResponsavel'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Pode ser chamado SAMU?: {{ $campos['podeSerChamadoSAMU'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Identificação do curso</h2>
        <p>Nome do curso: {{ $campos['nomeCurso'] ?? '---' }}</p>
        <p>Forma de oferta: {{ $campos['formaOferta'] ?? '---' }}</p>
        <p>Matrícula: {{ $campos['matricula'] ?? '---' }}</p>
        <p>Turno: {{ $campos['turno'] ?? '---' }}</p>
        <p>Ano/Período: {{ $campos['anoPeriodo'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Cota de Ingresso</h2>
        <p>Cota: {{ $campos['cota'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Informações Familiares</h2>
        <p>Formação da mãe: {{ $campos['formacaoMae'] ?? '---' }}</p>
        <p>Profissão da mãe: {{ $campos['profissaoMae'] ?? '---' }}</p>
        <p>Idade da mãe: {{ $campos['idadeMae'] ?? '---' }}</p>
        <p>A mãe está atualmente empregada?: {{ $campos['maeEmpregada'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Formação do pai: {{ $campos['formacaoPai'] ?? '---' }}</p>
        <p>Profissão do pai: {{ $campos['profissaoPai'] ?? '---' }}</p>
        <p>Idade do pai: {{ $campos['idadePai'] ?? '---' }}</p>
        <p>O pai está atualmente empregado?: {{ $campos['paiEmpregado'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Formação do responsável: {{ $campos['formacaoResponsavel'] ?? '---' }}</p>
        <p>Profissão do responsável: {{ $campos['profissaoResponsavel'] ?? '---' }}</p>
        <p>Idade do responsável: {{ $campos['idadeResponsavel'] ?? '---' }}</p>
        <p>O responsável está atualmente empregado?: {{ $campos['responsavelEmpregado'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Número de irmãos: {{ $campos['numeroIrmaos'] ?? '---' }}</p>
        <p>Estudante mora com: {{ $campos['moraCom'] ?? '---' }}</p>
        <p>Pais separados?: {{ $campos['paisSeparados'] ?? '---' }}</p>
        <p>Alguma pessoa da família tem deficiência?: {{ $campos['deficiencia'] ?? '---' }}</p>
        <p>Se sim, qual?: {{ $campos['tipoDeficiencia'] ?? '---' }}</p>
        <p>Rotina diária antes e depois das aulas/atividades domésticas: {{ $campos['rotinaDiaria'] ?? '---' }}</p>
        <p>Relacionamento com familiares: {{ $campos['relacionamentoFamiliares'] ?? '---' }}</p>
        <p>Com quem mais convive fora da escola?: {{ $campos['comQuemConvive'] ?? '---' }}</p>
        <p>Mantém amizades com pessoas da mesma idade: {{ $campos['mantemAmizades'] ?? '---' }}</p>
        <p>A família se reúne para atividades de lazer? Que tipo?: {{ $campos['atividadesLazer'] ?? '---' }}</p>
        <p>Condições de moradia (casa própria, alugada, outro): {{ $campos['condicoesMoradia'] ?? '---' }}</p>
        <p>Tem ambiente específico para estudo? Como é?: {{ $campos['ambienteEstudo'] ?? '---' }}</p>
        <p>Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?: {{ $campos['acompanhamento'] ?? '---' }}</p>
        <p>Qual é o local da casa onde o estudante permanece mais tempo?: {{ $campos['localPermanencia'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">5. História Escolar do Estudante</h2>
        <p>Qual a escola de origem?: {{ $campos['escolaOrigem'] ?? '---' }}</p>
        <p>Há quanto tempo no IFPR?: {{ $campos['tempoIFPR'] ?? '---' }}</p>
        <p>Já reprovou algum ano escolar? Qual? Motivo?: {{ $campos['reprovacao'] ?? '---' }}</p>
        <p>Áreas de conhecimento com as quais têm mais facilidade na escola: {{ $campos['areasFacilidade'] ?? '---' }}</p>
        <p>Áreas de conhecimento com as quais têm mais dificuldade na escola: {{ $campos['areasDificuldade'] ?? '---' }}</p>
        <p>Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes): {{ $campos['trajetoriaEscolar'] ?? '---' }}</p>
        <p>Frequentou educação infantil a partir de que idade?: {{ $campos['frequentouEducacaoInfantil'] ?? '---' }}</p>
        <p>Com quantos anos aprendeu a ler e escrever?: {{ $campos['aprendeuLerEscrever'] ?? '---' }}</p>
        <p>Quais os cursos extra-escolares que já fez?: {{ $campos['cursosExtraEscolares'] ?? '---' }}</p>
        <p>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?: {{ $campos['atendimentoEduacionalEspecializado'] ?? '---' }}</p>
        <p>Foi necessária alguma Adaptação Curricular? Qual(is)?: {{ $campos['adaptacaoCurricular'] ?? '---' }}</p>
        <p>Outras necessidades relatadas e/ou percebidas: {{ $campos['outrasNecessidades'] ?? '---' }}</p>
        <p>Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela.: {{ $campos['potencialidades'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">6. Desenvolvimento biopsicosocial</h2>
        <p>Gestação planejada/desejada: {{ $campos['gestacaoPlanejada'] ?? '---' }}</p>
        <p>Fez pré-natal?: {{ $campos['fezPreNatal'] ?? '---' }}</p>
        <p>Doenças apresentadas?: {{ $campos['doencasApresentadas'] ?? '---' }}</p>
        <p>Usou fraldas até que idade?: {{ $campos['usouFraldas'] ?? '---' }}</p>
        <p>Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?: {{ $campos['ateQueIdadeMamadeira'] ?? '---' }}</p>
        <p>Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)?: {{ $campos['desenvolvimentoFalaAndar'] ?? '---' }}</p>
        <p>As indicações de vacinação foram cumpridas? Se não, por quê?: {{ $campos['IndicacoesVacinacao'] ?? '---' }}</p>
        <p>Faz uso de medicamento?: {{ $campos['fazUsoMedicamento'] ?? '---' }}</p>
        <p>Seletividade ou restrição alimentar?: {{ $campos['seletividadeRestricaoAlimentar'] ?? '---' }}</p>
        <p>Internamentos e cirurgias?: {{ $campos['internamentosCirurgias'] ?? '---' }}</p>
        <p>Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)?: {{ $campos['deficienciaTranstornos'] ?? '---' }}</p>
        <p>Fez ou faz algum acompanhamento com profissional de Saúde externo?: {{ $campos['acompanhamentoSaudeExterno'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Nome do fisioterapeuta?: {{ $campos['nomeFisioterapeuta'] ?? '---' }}</p>
        <p>Contato do fisioterapeuta?: {{ $campos['contatoFisioterapeuta'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Nome do fonoaudiólogo?: {{ $campos['nomeFonoaudiologo'] ?? '---' }}</p>
        <p>Contato do fonoaudiólogo?: {{ $campos['contatoFonoaudiologo'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Nome do psicólogo?: {{ $campos['nomePsicologo'] ?? '---' }}</p>
        <p>Contato do psicólogo?: {{ $campos['contatoPsicologo'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Nome do neurologista?: {{ $campos['nomeNeurologista'] ?? '---' }}</p>
        <p>Contato do neurologista?: {{ $campos['contatoNeurologista'] ?? '---' }}</p>
        <hr class="text-on-surface">
        <p>Observações?: {{ $campos['observacoes'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">7. Características de comportamento do Estudante</h2>
        <p>Timido?: {{ $campos['timido'] ?? '---' }}</p>
        <p>Extrovertido?: {{ $campos['extrovertido'] ?? '---' }}</p>
        <p>Persistente?: {{ $campos['persistente'] ?? '---' }}</p>
        <p>Calmo?: {{ $campos['calmo'] ?? '---' }}</p>
        <p>Agitado?: {{ $campos['agitado'] ?? '---' }}</p>
        <p>Ansioso?: {{ $campos['ansioso'] ?? '---' }}</p>
        <p>Organizado?: {{ $campos['organizado'] ?? '---' }}</p>
        <p>Perfeccionista?: {{ $campos['perfeccionista'] ?? '---' }}</p>
        <p>Responsável?: {{ $campos['responsavel'] ?? '---' }}</p>
        <p>Amoroso?: {{ $campos['amoroso'] ?? '---' }}</p>
        <p>Nervoso?: {{ $campos['nervoso'] ?? '---' }}</p>
        <p>Inseguro?: {{ $campos['inseguro'] ?? '---' }}</p>
        <p>Outros?: {{ $campos['outros'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">8. Informações Gerais e de âmbito escolar</h2>
        <p>Origem e histórico do caso e dos atendimentos: {{ $campos['origemHistorico'] ?? '---' }}</p>
        <p>Faz uso de algum artefato para mobilidade? Qual(is)?: {{ $campos['artefatosMobilidade'] ?? '---' }}</p>
        <p>Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.): {{ $campos['adaptacaoMobiliario'] ?? '---' }}</p>
        <p>É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?: {{ $campos['necessidadeLocacao'] ?? '---' }}</p>
        <p>Necessita de alguma adaptação para a utilização do computador? Qual?: {{ $campos['adaptacaoComputador'] ?? '---' }}</p>
        <p>Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?: {{ $campos['transporteCampus'] ?? '---' }}</p>
        <p>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?: {{ $campos['atendimentoEducativo'] ?? '---' }}</p>
        <p>Foi necessária alguma Adaptação Curricular? Qual(is)?: {{ $campos['necessidadeAdaptacaoCurricular'] ?? '---' }}</p>
        <p>Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros): {{ $campos['sistemaLinguistico'] ?? '---' }}</p>
        <p>Recursos ou equipamentos de acessibilidade já usados pelo estudante: {{ $campos['recursosAcessibilidade'] ?? '---' }}</p>
        <p>Recursos ou equipamentos que necessitam ser providenciados: {{ $campos['recursosProvidenciados'] ?? '---' }}</p>
        <p>Outras necessidades relatadas e/ou percebidas: {{ $campos['outrasNecessidadesEscolares'] ?? '---' }}</p>
        <p>Sugestões para melhoria da adaptação: {{ $campos['sugestoesAdaptacao'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com a escola anterior</h2>
        <p>Teve acompanhamento de AEE? Fez uso da sala de recurso?: {{ $campos['acompanhamentoAEE'] ?? '---' }}</p>
        <p>Potencialidades e dificuldades acadêmicas: {{ $campos['potencialidadesDificuldades'] ?? '---' }}</p>
        <p>Tinha material adaptado? Quais?: {{ $campos['materialAdaptado'] ?? '---' }}</p>
        <p>Participou de apoio escolar? Qual?: {{ $campos['apoioEscolar'] ?? '---' }}</p>
        <p>Algum comportamento diferenciado?: {{ $campos['comportamentoDiferenciado'] ?? '---' }}</p>
        <p>Alguma questão de sensibilidade?: {{ $campos['questaoSensibilidade'] ?? '---' }}</p>
        <p>Algum momento de crise? Que tipo?: {{ $campos['momentoCrise'] ?? '---' }}</p>
        <p>Teve laudo por encaminhamento da escola?: {{ $campos['laudoEscola'] ?? '---' }}</p>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com profissionais externos</h2>
        <p>Quando começou o tratamento?: {{ $campos['inicioTratamento'] ?? '---' }}</p>
        <p>Por que começou?: {{ $campos['porQueComecou'] ?? '---' }}</p>
        <p>Apresenta crises de comportamento?: {{ $campos['apresentaCrisesComportamento'] ?? '---' }}</p>
        <p>Qual ou quais situações desencadeiam crises?: {{ $campos['qualSituacoesDesencadeiamCrises'] ?? '---' }}</p>
        <p>Orientações para evitar estresse: {{ $campos['orientacoesEvitarEstresse'] ?? '---' }}</p>
        <p>Quais as melhorias?: {{ $campos['quaisMelhorias'] ?? '---' }}</p>
        <p>Maiores orientações para sala de aula e escola: {{ $campos['maioresOrientacoes'] ?? '---' }}</p>
        <p>Necessita de abafador de som no ambiente escolar?: {{ $campos['necessitaAbafadorSom'] ?? '---' }}</p>
        <p>Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?: {{ $campos['comoSeOrganiza'] ?? '---' }}</p>
        <p>Como o estudante aprende?: {{ $campos['comoAprende'] ?? '---' }}</p>
        <p>Quais recursos e/ou estratégias facilitam sua aprendizagem?: {{ $campos['quaisRecursosFacilitam'] ?? '---' }}</p>
        <p>Quais recursos e/ou estratégias dificultam sua aprendizagem?: {{ $campos['quaisRecursosDificultam'] ?? '---' }}</p>
        <p>Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?: {{ $campos['emQueAreaFacilidade'] ?? '---' }}</p>
        <p>Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?: {{ $campos['emQueAreaDificuldade'] ?? '---' }}</p>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel label="Voltar" color="tertiary" fallback="estudantes.show" :args="['estudante' => $estudante]" />

        @can('update', $entrevistaFamiliar)
            <x-button label="Editar" type="link" href="{{ route('estudantes.entrevistas-familiares.edit', ['estudante' => $estudante, 'entrevistaFamiliar' => $entrevistaFamiliar]) }}" color="yellow" />
        @endcan

        @can('delete', $entrevistaFamiliar)
            <x-modal icon="delete" label="Excluir" color="red" title="Excluir Entrevista Familiar">
                <p class="mb-5 text-body-large">
                    Tem certeza que deseja excluir esta entrevista familiar?<br>
                    Você poderá restaurá-la posteriormente.
                </p>

                <div class="flex justify-end gap-3 mb-2">
                    <x-button label="Cancelar" color="secondary" x-on:click="show=false" />

                    <form action="{{ route('estudantes.entrevistas-familiares.destroy', ['estudante' => $estudante, 'entrevistaFamiliar' => $entrevistaFamiliar]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <x-button label="Confirmar" type="submit" color="red" />
                    </form>
                </div>
            </x-modal>
        @endcan
    </div>
</x-layouts.main>
