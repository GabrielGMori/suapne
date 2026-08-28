@props(['entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;
?>

<x-layouts.main title="Entrevista Escolar Familiar de {{ $entrevistaFamiliar->estudante->nome}}">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-title-large ">Data da entrevista: {{$entrevistaFamiliar->data->format('d/m/Y')}}</h2>
        <x-button label="Exportar como PDF" icon="file_export" iconPos="right" color="tertiary"/>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Identificação do Estudante</h2>
        <hr class="text-on-surface">
        <p>Nome completo do estudante: {{$entrevistaFamiliar->campos['nomeCompleto']}}</p>
        <p>Nome social: {{$entrevistaFamiliar->campos['nomeSocial']}}</p>
        <hr class="text-on-surface">
        <p>Idade: {{$entrevistaFamiliar->campos['idade']}}</p>
        <p>Dia de nascimento: {{$entrevistaFamiliar->campos['dataNascimento']}}</p>
        <hr class="text-on-surface">
        <p>Nome completo da mãe: {{$entrevistaFamiliar->campos['nomeMae']}}</p>
        <p>Nome completo do pai: {{$entrevistaFamiliar->campos['nomePai']}}</p>
        <p>Nome completo da responsável: {{$entrevistaFamiliar->campos['nomeResponsavel']}}</p>
        <hr class="text-on-surface">
        <p>Celular do estudante: {{$entrevistaFamiliar->campos['celularEstudante']}}</p>
        <p>Celular da mãe: {{$entrevistaFamiliar->campos['celularMae']}}</p>
        <p>Celular do pai: {{$entrevistaFamiliar->campos['celularPai']}}</p>
        <p>Celular fixo: {{$entrevistaFamiliar->campos['celularFixo']}}</p>
        <hr class="text-on-surface">
        <p>Email do estudante: {{$entrevistaFamiliar->campos['emailEstudante']}}</p>
        <p>Email da mãe: {{$entrevistaFamiliar->campos['emailMae']}}</p>
        <p>Email do pai: {{$entrevistaFamiliar->campos['emailPai']}}</p>
        <p>Email do responsável: {{$entrevistaFamiliar->campos['emailResponsavel']}}</p>

        <hr class="text-on-surface">
        <p>Pode ser chamado SAMU?: {{$entrevistaFamiliar->campos['podeSerChamadoSAMU']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Identificação do curso</h2>
        <p>Nome do curso: {{$entrevistaFamiliar->campos['nomeCurso']}}</p>
        <p>Forma de oferta: {{$entrevistaFamiliar->campos['formaOferta']}}</p>
        <p>Matrícula: {{$entrevistaFamiliar->campos['matricula']}}</p>
        <p>Turno: {{$entrevistaFamiliar->campos['turno']}}</p>
        <p>Ano/Período: {{$entrevistaFamiliar->campos['anoPeriodo']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Cota de Ingresso</h2>
        <p>Cota: {{$entrevistaFamiliar->campos['cota']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Informações Familiares</h2>
        <p>Formação da mãe: {{$entrevistaFamiliar->campos['formacaoMae']}}</p>
        <p>Profissão da mãe: {{$entrevistaFamiliar->campos['profissaoMae']}}</p>
        <p>Idade da mãe: {{$entrevistaFamiliar->campos['idadeMae']}}</p>
        <p>A mãe está atualmente empregada?: {{$entrevistaFamiliar->campos['maeEmpregada']}}</p>
        <hr class="text-on-surface">
        <p>Formação do pai: {{$entrevistaFamiliar->campos['formacaoPai']}}</p>
        <p>Profissão do pai: {{$entrevistaFamiliar->campos['profissaoPai']}}</p>
        <p>Idade do pai: {{$entrevistaFamiliar->campos['idadePai']}}</p>
        <p>O pai está atualmente empregado?: {{$entrevistaFamiliar->campos['paiEmpregado']}}</p>
        <hr class="text-on-surface">
        <p>Formação do responsável: {{$entrevistaFamiliar->campos['formacaoResponsavel']}}</p>
        <p>Profissão do responsável: {{$entrevistaFamiliar->campos['profissaoResponsavel']}}</p>
        <p>Idade do responsável: {{$entrevistaFamiliar->campos['idadeResponsavel']}}</p>
        <p>O responsável está atualmente empregado?: {{$entrevistaFamiliar->campos['responsavelEmpregado']}}</p>
        <hr class="text-on-surface">
        <p>Número de irmãos: {{$entrevistaFamiliar->campos['numeroIrmaos']}}</p>
        <p>Estudante mora com: {{$entrevistaFamiliar->campos['moraCom']}}</p>
        <p>Pais separados?: {{$entrevistaFamiliar->campos['paisSeparados']}}</p>
        <p>Alguma pessoa da família tem deficiência?: {{$entrevistaFamiliar->campos['deficiencia']}}</p>
        <p>Se sim, qual?: {{$entrevistaFamiliar->campos['tipoDeficiencia']}}</p>
        <p>Rotina diária antes e depois das aulas/atividades domésticas: {{$entrevistaFamiliar->campos['rotinaDiaria']}}</p>
        <p>Relacionamento com familiares: {{$entrevistaFamiliar->campos['relacionamentoFamiliares']}}</p>
        <p>Com quem mais convive fora da escola?: {{$entrevistaFamiliar->campos['comQuemConvive']}}</p>
        <p>Mantém amizades com pessoas da mesma idade: {{$entrevistaFamiliar->campos['mantemAmizades']}}</p>
        <p>A família se reúne para atividades de lazer? Que tipo?: {{$entrevistaFamiliar->campos['atividadesLazer']}}</p>
        <p>Condições de moradia (casa própria, alugada, outro): {{$entrevistaFamiliar->campos['condicoesMoradia']}}</p>
        <p>Tem ambiente específico para estudo? Como é?: {{$entrevistaFamiliar->campos['ambienteEstudo']}}</p>
        <p>Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?: {{$entrevistaFamiliar->campos['acompanhamento']}}</p>
        <p>Qual é o local da casa onde o estudante permanece mais tempo?: {{$entrevistaFamiliar->campos['localPermanencia']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">5. História Escolar do Estudante</h2>
        <p>Qual a escola de origem?: {{$entrevistaFamiliar->campos['escolaOrigem']}}</p>
        <p>Há quanto tempo no IFPR?: {{$entrevistaFamiliar->campos['tempoIFPR']}}</p>
        <p>Já reprovou algum ano escolar? Qual? Motivo?: {{$entrevistaFamiliar->campos['reprovacao']}}</p>
        <p>Áreas de conhecimento com as quais têm mais facilidade na escola: {{$entrevistaFamiliar->campos['areasFacilidade']}}</p>
        <p>Áreas de conhecimento com as quais têm mais dificuldade na escola: {{$entrevistaFamiliar->campos['areasDificuldade']}}</p>
        <p>Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes): {{$entrevistaFamiliar->campos['trajetoriaEscolar']}}</p>
        <p>Frequentou educação infantil a partir de que idade?: {{$entrevistaFamiliar->campos['frequentouEducacaoInfantil']}}</p>
        <p>Com quantos anos aprendeu a ler e escrever?: {{$entrevistaFamiliar->campos['aprendeuLerEscrever']}}</p>
        <p>Quais os cursos extra-escolares que já fez?: {{$entrevistaFamiliar->campos['cursosExtraEscolares']}}</p>
        <p>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?: {{$entrevistaFamiliar->campos['atendimentoEduacionalEspecializado']}}</p>
        <p>Foi necessária alguma Adaptação Curricular? Qual(is)?: {{$entrevistaFamiliar->campos['adaptacaoCurricular']}}</p>
        <p>Outras necessidades relatadas e/ou percebidas: {{$entrevistaFamiliar->campos['outrasNecessidades']}}</p>
        <p>Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela.: {{$entrevistaFamiliar->campos['potencialidades']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">6. Desenvolvimento biopsicosocial</h2>
        <p>Gestação planejada/desejada: {{$entrevistaFamiliar->campos['gestacaoPlanejada']}}</p>
        <p>Fez pré-natal?: {{$entrevistaFamiliar->campos['fezPreNatal']}}</p>
        <p>Doenças apresentadas?: {{$entrevistaFamiliar->campos['doencasApresentadas']}}</p>
        <p>Usou fraldas até que idade?: {{$entrevistaFamiliar->campos['usouFraldas']}}</p>
        <p>Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?: {{$entrevistaFamiliar->campos['ateQueIdadeMamadeira']}}</p>
        <p>Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)?: {{$entrevistaFamiliar->campos['desenvolvimentoFalaAndar']}}</p>
        <p>As indicações de vacinação foram cumpridas? Se não, por quê?: {{$entrevistaFamiliar->campos['IndicacoesVacinacao']}}</p>
        <p>Faz uso de medicamento?: {{$entrevistaFamiliar->campos['fazUsoMedicamento']}}</p>
        <p>Seletividade ou restrição alimentar?: {{$entrevistaFamiliar->campos['seletividadeRestricaoAlimentar']}}</p>
        <p>Internamentos e cirurgias?: {{$entrevistaFamiliar->campos['internamentosCirurgias']}}</p>
        <p>Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)?: {{$entrevistaFamiliar->campos['deficienciaTranstornos']}}</p>
        <p>Fez ou faz algum acompanhamento com profissional de Saúde externo?: {{$entrevistaFamiliar->campos['acompanhamentoSaudeExterno']}}</p>
        <hr class="text-on-surface">
        <p>Nome do fisioterapeuta?: {{$entrevistaFamiliar->campos['nomeFisioterapeuta']}}</p>
        <p>Contato do fisioterapeuta?: {{$entrevistaFamiliar->campos['contatoFisioterapeuta']}}</p>
        <hr class="text-on-surface">
        <p>Nome do fonoaudiólogo?: {{$entrevistaFamiliar->campos['nomeFonoaudiologo']}}</p>
        <p>Contato do fonoaudiólogo?: {{$entrevistaFamiliar->campos['contatoFonoaudiologo']}}</p>
        <hr class="text-on-surface">
        <p>Nome do psicólogo?: {{$entrevistaFamiliar->campos['nomePsicologo']}}</p>
        <p>Contato do psicólogo?: {{$entrevistaFamiliar->campos['contatoPsicologo']}}</p>
        <hr class="text-on-surface">
        <p>Nome do neurologista?: {{$entrevistaFamiliar->campos['nomeNeurologista']}}</p>
        <p>Contato do neurologista?: {{$entrevistaFamiliar->campos['contatoNeurologista']}}</p>
        <hr class="text-on-surface">
        <p>Observações?: {{$entrevistaFamiliar->campos['observacoes']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">7. Características de comportamento do Estudante</h2>
        <p>Timido?: {{$entrevistaFamiliar->campos['timido']}}</p>
        <p>Extrovertido?: {{$entrevistaFamiliar->campos['extrovertido']}}</p>
        <p>Persistente?: {{$entrevistaFamiliar->campos['persistente']}}</p>
        <p>Calmo?: {{$entrevistaFamiliar->campos['calmo']}}</p>
        <p>Agitado?: {{$entrevistaFamiliar->campos['agitado']}}</p>
        <p>Ansioso?: {{$entrevistaFamiliar->campos['ansioso']}}</p>
        <p>Organizado?: {{$entrevistaFamiliar->campos['organizado']}}</p>
        <p>Perfeccionista?: {{$entrevistaFamiliar->campos['perfeccionista']}}</p>
        <p>Responsável?: {{$entrevistaFamiliar->campos['responsavel']}}</p>
        <p>Amoroso?: {{$entrevistaFamiliar->campos['amoroso']}}</p>
        <p>Nervoso?: {{$entrevistaFamiliar->campos['nervoso']}}</p>
        <p>Inseguro?: {{$entrevistaFamiliar->campos['inseguro']}}</p>
        <p>Outros?: {{$entrevistaFamiliar->campos['outros']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">8. Informações Gerais e de âmbito escolar</h2>
        <p>Origem e histórico do caso e dos atendimentos: {{$entrevistaFamiliar->campos['origemHistorico']}}</p>
        <p>Faz uso de algum artefato para mobilidade? Qual(is)?: {{$entrevistaFamiliar->campos['artefatosMobilidade']}}</p>
        <p>Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.): {{$entrevistaFamiliar->campos['adaptacaoMobiliario']}}</p>
        <p>É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?: {{$entrevistaFamiliar->campos['necessidadeLocacao']}}</p>
        <p>Necessita de alguma adaptação para a utilização do computador? Qual?: {{$entrevistaFamiliar->campos['adaptacaoComputador']}}</p>
        <p>Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?: {{$entrevistaFamiliar->campos['transporteCampus']}}</p>
        <p>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?: {{$entrevistaFamiliar->campos['atendimentoEducativo']}}</p>
        <p>Foi necessária alguma Adaptação Curricular? Qual(is)?: {{$entrevistaFamiliar->campos['necessidadeAdaptacaoCurricular']}}</p>
        <p>Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros): {{$entrevistaFamiliar->campos['sistemaLinguistico']}}</p>
        <p>Recursos ou equipamentos de acessibilidade já usados pelo estudante: {{$entrevistaFamiliar->campos['recursosAcessibilidade']}}</p>
        <p>Recursos ou equipamentos que necessitam ser providenciados: {{$entrevistaFamiliar->campos['recursosProvidenciados']}}</p>
        <p>Outras necessidades relatadas e/ou percebidas: {{$entrevistaFamiliar->campos['outrasNecessidadesEscolares']}}</p>
        <p>Sugestões para melhoria da adaptação: {{$entrevistaFamiliar->campos['sugestoesAdaptacao']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com a escola anterior</h2>
        <p>Teve acompanhamento de AEE? Fez uso da sala de recurso?: {{$entrevistaFamiliar->campos['acompanhamentoAEE']}}</p>
        <p>Potencialidades e dificuldades acadêmicas: {{$entrevistaFamiliar->campos['potencialidadesDificuldades']}}</p>
        <p>Tinha material adaptado? Quais?: {{$entrevistaFamiliar->campos['materialAdaptado']}}</p>
        <p>Participou de apoio escolar? Qual?: {{$entrevistaFamiliar->campos['apoioEscolar']}}</p>
        <p>Algum comportamento diferenciado?: {{$entrevistaFamiliar->campos['comportamentoDiferenciado']}}</p>
        <p>Alguma questão de sensibilidade?: {{$entrevistaFamiliar->campos['questaoSensibilidade']}}</p>
        <p>Algum momento de crise? Que tipo?: {{$entrevistaFamiliar->campos['momentoCrise']}}</p>
        <p>Teve laudo por encaminhamento da escola?: {{$entrevistaFamiliar->campos['laudoEscola']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com profissionais externos</h2>
        <p>Quando começou o tratamento?: {{$entrevistaFamiliar->campos['inicioTratamento']}}</p>
        <p>Por que começou?: {{$entrevistaFamiliar->campos['porQueComecou']}}</p>
        <p>Apresenta crises de comportamento?: {{$entrevistaFamiliar->campos['apresentaCrisesComportamento']}}</p>
        <p>Qual ou quais situações desencadeiam crises?: {{$entrevistaFamiliar->campos['qualSituacoesDesencadeiamCrises']}}</p>
        <p>Orientações para evitar estresse: {{$entrevistaFamiliar->campos['orientacoesEvitarEstresse']}}</p>
        <p>Quais as melhorias?: {{$entrevistaFamiliar->campos['quaisMelhorias']}}</p>
        <p>Maiores orientações para sala de aula e escola: {{$entrevistaFamiliar->campos['maioresOrientacoes']}}</p>
        <p>Necessita de abafador de som no ambiente escolar?: {{$entrevistaFamiliar->campos['necessitaAbafadorSom']}}</p>
        <p>Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?: {{$entrevistaFamiliar->campos['comoSeOrganiza']}}</p>
        <p>Como o estudante aprende?: {{$entrevistaFamiliar->campos['comoAprende']}}</p>
        <p>Quais recursos e/ou estratégias facilitam sua aprendizagem?: {{$entrevistaFamiliar->campos['quaisRecursosFacilitam']}}</p>
        <p>Quais recursos e/ou estratégias dificultam sua aprendizagem?: {{$entrevistaFamiliar->campos['quaisRecursosDificultam']}}</p>
        <p>Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?: {{$entrevistaFamiliar->campos['emQueAreaFacilidade']}}</p>
        <p>Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?: {{$entrevistaFamiliar->campos['emQueAreaDificuldade']}}</p>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel label="Voltar" color="tertiary" fallback="estudantes.show" :args="['id' => $entrevistaFamiliar->estudante->id, 'estudante'=>$estudante]" color="tertiary" />
    </div>
</x-layouts.main>
