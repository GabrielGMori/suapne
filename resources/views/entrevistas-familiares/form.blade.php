@props(['estudante' => null, 'entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;
?>

<x-layouts.main title="{{ $entrevistaFamiliar == null ? 'Entrevista Escolar Familiar' : 'Editar Entrevista Escolar Familiar' }}">
    <form action="{{ $entrevistaFamiliar == null ? route('estudantes.entrevistas-familiares.store', ['estudante' => $estudante?->id]) : route('estudantes.entrevistas-familiares.update', ['estudante' => $estudante?->id, 'entrevistaFamiliar' => $entrevistaFamiliar]) }}"
        method="POST">
        @if ($entrevistaFamiliar !== null)
            @method('PATCH')
        @endif
        @csrf
        <x-secao-expansivel title="1. Identificação do Estudante" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input type="date" label="Data da entrevista" appearance="outlined" size="small"
                    name="data" :value="old('data', $entrevistaFamiliar?->data?->format('Y-m-d'))" required />
                <x-form.input label="Responsável pelo preenchimento" appearance="outlined" size="large"
                    name="responsavel_preenchimento" :value="old('responsavel_preenchimento', $entrevistaFamiliar?->responsavel_preenchimento ?? '')" required />
                <hr class="text-on-surface">
                <x-form.input label="Nome completo do estudante" appearance="outlined" size="large"
                    name="campos[nomeCompleto]" :value="old('campos.nomeCompleto', $entrevistaFamiliar?->campos['nomeCompleto'] ?? ($estudante?->nome ?? ''))" />
                <x-form.input label="Nome social" appearance="outlined" size="large"
                    name="campos[nomeSocial]" :value="old('campos.nomeSocial', $entrevistaFamiliar?->campos['nomeSocial'] ?? '')" />
                <hr class="text-on-surface">
                <x-form.input type="number" label="Idade" appearance="outlined" size="small"
                    name="campos[idade]" :value="old('campos.idade', $entrevistaFamiliar?->campos['idade'] ?? ($estudante?->idade ?? ''))" />
                <x-form.input type="date" label="Data de nascimento" appearance="outlined" size="small"
                    name="campos[dataNascimento]" :value="old('campos.dataNascimento', $entrevistaFamiliar?->campos['dataNascimento'] ?? ($estudante?->nascimento?->format('Y-m-d') ?? ''))" />
                <hr class="text-on-surface">
                <livewire:form.select label="Pode ser chamado SAMU?" placeholder="Selecionar" appearance="outlined" size="small"
                    name="campos[podeSerChamadoSAMU]" :options="['Sim' => 'Sim', 'Não' => 'Não']" :value="old('campos.podeSerChamadoSAMU', $entrevistaFamiliar?->campos['podeSerChamadoSAMU'] ?? '')" />
                <hr class="text-on-surface">
                <x-form.input label="Nome completo da mãe" appearance="outlined" size="large"
                    name="campos[nomeMae]" :value="old('campos.nomeMae', $entrevistaFamiliar?->campos['nomeMae'] ?? ($estudante?->nome_mae ?? ''))" />
                <x-form.input label="Nome completo do pai" appearance="outlined" size="large"
                    name="campos[nomePai]" :value="old('campos.nomePai', $entrevistaFamiliar?->campos['nomePai'] ?? ($estudante?->nome_pai ?? ''))" />
                <x-form.input label="Nome completo da responsável" appearance="outlined" size="large"
                    name="campos[nomeResponsavel]" :value="old('campos.nomeResponsavel', $entrevistaFamiliar?->campos['nomeResponsavel'] ?? ($estudante?->nome_responsavel ?? ''))" />
                <hr class="text-on-surface">
                <x-form.input type="tel" label="Celular do estudante" appearance="outlined" size="small"
                    name="campos[celularEstudante]" :value="old('campos.celularEstudante', $entrevistaFamiliar?->campos['celularEstudante'] ?? ($estudante?->telefone ?? ''))" />
                <x-form.input type="tel" label="Celular da mãe" appearance="outlined" size="small"
                    name="campos[celularMae]" :value="old('campos.celularMae', $entrevistaFamiliar?->campos['celularMae'] ?? ($estudante?->telefone_mae ?? ''))" />
                <x-form.input type="tel" label="Celular do pai" appearance="outlined" size="small"
                    name="campos[celularPai]" :value="old('campos.celularPai', $entrevistaFamiliar?->campos['celularPai'] ?? ($estudante?->telefone_pai ?? ''))" />
                <x-form.input type="tel" label="Celular fixo" appearance="outlined" size="small"
                    name="campos[celularFixo]" :value="old('campos.celularFixo', $entrevistaFamiliar?->campos['celularFixo'] ?? ($estudante?->telefone ?? ''))" />
                <hr class="text-on-surface">
                <x-form.input type="email" label="Email do estudante" appearance="outlined" size="large"
                    name="campos[emailEstudante]" :value="old('campos.emailEstudante', $entrevistaFamiliar?->campos['emailEstudante'] ?? ($estudante?->email_pessoal ?? ''))" />
                <x-form.input type="email" label="Email da mãe" appearance="outlined" size="large"
                    name="campos[emailMae]" :value="old('campos.emailMae', $entrevistaFamiliar?->campos['emailMae'] ?? '')" />
                <x-form.input type="email" label="Email do pai" appearance="outlined" size="large"
                    name="campos[emailPai]" :value="old('campos.emailPai', $entrevistaFamiliar?->campos['emailPai'] ?? '')" />
                <x-form.input type="email" label="Email do responsável" appearance="outlined" size="large"
                    name="campos[emailResponsavel]" :value="old('campos.emailResponsavel', $entrevistaFamiliar?->campos['emailResponsavel'] ?? ($estudante?->email_responsavel ?? ''))" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="2. Identificação do curso" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Nome do curso" appearance="outlined" size="large"
                    name="campos[nomeCurso]" :value="old('campos.nomeCurso', $entrevistaFamiliar?->campos['nomeCurso'] ?? ($estudante?->curso?->nome ?? ''))" />
                <livewire:form.select label="Forma de oferta" placeholder="Selecionar" appearance="outlined"
                    size="medium" :options="[
                        'FIC' => 'FIC',
                        'Proeja' => 'Proeja',
                        'Integrado' => 'Integrado',
                        'Subsequente' => 'Subsequente',
                        'Graduação - Licenciatura' => 'Graduação - Licenciatura',
                        'Graduação - Bacharelado' => 'Graduação - Bacharelado',
                        'Graduação - Tecnólogo' => 'Graduação - Tecnólogo',
                        'Especialização' => 'Especialização',
                        'Mestrado' => 'Mestrado',
                    ]" name="campos[formaOferta]" :value="old('campos.formaOferta', $entrevistaFamiliar?->campos['formaOferta'] ?? '')" />
                <livewire:form.select label="Cota" placeholder="Selecionar" appearance="outlined" size="medium"
                    :options="[
                        'PNE' => 'PNE',
                        'Pretos ou Pardos' => 'Pretos ou Pardos',
                        'Indígenas' => 'Indígenas',
                        'Entrada por sorteio público' => 'Entrada por sorteio público',
                        'Social' => 'Social',
                        'Escola Pública' => 'Escola Pública',
                        'Ampla Concorrência' => 'Ampla Concorrência',
                        'Quilombola' => 'Quilombola',
                    ]" name="campos[cota]" :value="old('campos.cota', $entrevistaFamiliar?->campos['cota'] ?? '')" />
                <x-form.input label="Matricula" appearance="outlined" size="small" name="campos[matricula]"
                    :value="old('campos.matricula', $entrevistaFamiliar?->campos['matricula'] ?? ($estudante?->matricula ?? ''))" />
                <livewire:form.select label="Turno" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Matutino' => 'Matutino', 'Vespertino' => 'Vespertino', 'Noturno' => 'Noturno']" name="campos[turno]"
                    :value="old('campos.turno', $entrevistaFamiliar?->campos['turno'] ?? '')" />
                <x-form.input label="Ano/Período" appearance="outlined" size="small"
                    name="campos[anoPeriodo]" :value="old('campos.anoPeriodo', $entrevistaFamiliar?->campos['anoPeriodo'] ?? ($estudante?->periodo ?? ''))" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="3. Informações Familiares" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Formação da mãe" appearance="outlined" size="large"
                    name="campos[formacaoMae]" :value="old('campos.formacaoMae', $entrevistaFamiliar?->campos['formacaoMae'] ?? '')" />
                <x-form.input label="Profissão da mãe" appearance="outlined" size="large"
                    name="campos[profissaoMae]" :value="old('campos.profissaoMae', $entrevistaFamiliar?->campos['profissaoMae'] ?? '')" />
                <x-form.input type="number" label="Idade da mãe" appearance="outlined" size="small"
                    name="campos[idadeMae]" :value="old('campos.idadeMae', $entrevistaFamiliar?->campos['idadeMae'] ?? '')" />
                <x-form.input label="A mãe está atualmente empregada?" appearance="outlined" size="medium"
                    name="campos[maeEmpregada]" :value="old('campos.maeEmpregada', $entrevistaFamiliar?->campos['maeEmpregada'] ?? '')" />
                <hr class="text-on-surface">
                <x-form.input label="Formação do pai" appearance="outlined" size="large"
                    name="campos[formacaoPai]" :value="old('campos.formacaoPai', $entrevistaFamiliar?->campos['formacaoPai'] ?? '')" />
                <x-form.input label="Profissão do pai" appearance="outlined" size="large"
                    name="campos[profissaoPai]" :value="old('campos.profissaoPai', $entrevistaFamiliar?->campos['profissaoPai'] ?? '')" />
                <x-form.input type="number" label="Idade do pai" appearance="outlined" size="small"
                    name="campos[idadePai]" :value="old('campos.idadePai', $entrevistaFamiliar?->campos['idadePai'] ?? '')" />
                <x-form.input label="O pai está atualmente empregado?" appearance="outlined" size="medium"
                    name="campos[paiEmpregado]" :value="old('campos.paiEmpregado', $entrevistaFamiliar?->campos['paiEmpregado'] ?? '')" />
                <hr class="text-on-surface">
                <x-form.input label="Formação do responsável" appearance="outlined" size="large"
                    name="campos[formacaoResponsavel]" :value="old('campos.formacaoResponsavel', $entrevistaFamiliar?->campos['formacaoResponsavel'] ?? '')" />
                <x-form.input label="Profissão do responsável" appearance="outlined" size="large"
                    name="campos[profissaoResponsavel]" :value="old('campos.profissaoResponsavel', $entrevistaFamiliar?->campos['profissaoResponsavel'] ?? '')" />
                <x-form.input type="number" label="Idade do responsável" appearance="outlined" size="small"
                    name="campos[idadeResponsavel]" :value="old('campos.idadeResponsavel', $entrevistaFamiliar?->campos['idadeResponsavel'] ?? '')" />
                <x-form.input label="O responsável está atualmente empregado?" appearance="outlined" size="medium"
                    name="campos[responsavelEmpregado]" :value="old('campos.responsavelEmpregado', $entrevistaFamiliar?->campos['responsavelEmpregado'] ?? '')" />
                <hr class="text-on-surface">
                <x-form.input label="Número de irmãos" appearance="outlined" size="small"
                    name="campos[numeroIrmaos]" :value="old('campos.numeroIrmaos', $entrevistaFamiliar?->campos['numeroIrmaos'] ?? '')" />
                <x-form.input label="Estudante mora com" appearance="outlined" size="large"
                    name="campos[moraCom]" :value="old('campos.moraCom', $entrevistaFamiliar?->campos['moraCom'] ?? '')" />
                <livewire:form.select label="Pais separados?" placeholder="Selecionar" appearance="outlined"
                    size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[paisSeparados]"
                    :value="old('campos.paisSeparados', $entrevistaFamiliar?->campos['paisSeparados'] ?? '')" />
                <livewire:form.select label="Alguma pessoa da família tem deficiência?" placeholder="Selecionar"
                    appearance="outlined" size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[deficiencia]"
                    :value="old('campos.deficiencia', $entrevistaFamiliar?->campos['deficiencia'] ?? '')" />
                <x-form.input label="Se sim, qual?" appearance="outlined" size="large"
                    name="campos[tipoDeficiencia]" :value="old('campos.tipoDeficiencia', $entrevistaFamiliar?->campos['tipoDeficiencia'] ?? '')" />
                <x-form.input
                    label="Rotina diária antes e depois das aulas/atividades domésticas" appearance="outlined" size="full"
                    name="campos[rotinaDiaria]" :value="old('campos.rotinaDiaria', $entrevistaFamiliar?->campos['rotinaDiaria'] ?? '')" />
                <x-form.input label="Relacionamento com familiares" appearance="outlined" size="full"
                    name="campos[relacionamentoFamiliares]" :value="old('campos.relacionamentoFamiliares', $entrevistaFamiliar?->campos['relacionamentoFamiliares'] ?? '')" />
                <x-form.input label="Com quem mais convive fora da escola?" appearance="outlined" size="full"
                    name="campos[comQuemConvive]" :value="old('campos.comQuemConvive', $entrevistaFamiliar?->campos['comQuemConvive'] ?? '')" />
                <x-form.input label="Mantém amizades com pessoas da mesma idade" appearance="outlined" size="full"
                    name="campos[mantemAmizades]" :value="old('campos.mantemAmizades', $entrevistaFamiliar?->campos['mantemAmizades'] ?? '')" />
                <x-form.input label="A família se reúne para atividades de lazer? Que tipo?" appearance="outlined" size="full"
                    name="campos[atividadesLazer]" :value="old('campos.atividadesLazer', $entrevistaFamiliar?->campos['atividadesLazer'] ?? '')" />
                <x-form.input label="Condições de moradia (casa própria, alugada, outro)" appearance="outlined" size="large"
                    name="campos[condicoesMoradia]" :value="old('campos.condicoesMoradia', $entrevistaFamiliar?->campos['condicoesMoradia'] ?? '')" />
                <x-form.input label="Tem ambiente específico para estudo? Como é?" appearance="outlined" size="full"
                    name="campos[ambienteEstudo]" :value="old('campos.ambienteEstudo', $entrevistaFamiliar?->campos['ambienteEstudo'] ?? '')" />
                <x-form.input
                    label="Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?" appearance="outlined" size="full"
                    name="campos[acompanhamento]" :value="old('campos.acompanhamento', $entrevistaFamiliar?->campos['acompanhamento'] ?? '')" />
                <x-form.input
                    label="Qual é o local da casa onde o estudante permanece mais tempo?" appearance="outlined" size="large"
                    name="campos[localPermanencia]" :value="old('campos.localPermanencia', $entrevistaFamiliar?->campos['localPermanencia'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="4. História Escolar do Estudante" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Qual a escola de origem?" appearance="outlined" size="large"
                    name="campos[escolaOrigem]" :value="old('campos.escolaOrigem', $entrevistaFamiliar?->campos['escolaOrigem'] ?? '')" />
                <x-form.input label="Há quanto tempo no IFPR?" appearance="outlined" size="medium"
                    name="campos[tempoIFPR]" :value="old('campos.tempoIFPR', $entrevistaFamiliar?->campos['tempoIFPR'] ?? '')" />
                <x-form.input label="Já reprovou algum ano escolar? Qual? Motivo?" appearance="outlined" size="full"
                    name="campos[reprovacao]" :value="old('campos.reprovacao', $entrevistaFamiliar?->campos['reprovacao'] ?? '')" />
                <x-form.input
                    label="Áreas de conhecimento com as quais têm mais facilidade na escola" appearance="outlined" size="full"
                    name="campos[areasFacilidade]" :value="old('campos.areasFacilidade', $entrevistaFamiliar?->campos['areasFacilidade'] ?? '')" />
                <x-form.input
                    label="Áreas de conhecimento com as quais têm mais dificuldade na escola" appearance="outlined" size="full"
                    name="campos[areasDificuldade]" :value="old('campos.areasDificuldade', $entrevistaFamiliar?->campos['areasDificuldade'] ?? '')" />
                <x-form.input
                    label="Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes)"
                    appearance="outlined" size="full" name="campos[trajetoriaEscolar]" :value="old('campos.trajetoriaEscolar', $entrevistaFamiliar?->campos['trajetoriaEscolar'] ?? '')" />
                <x-form.input label="Frequentou educação infantil a partir de que idade?" appearance="outlined" size="large"
                    name="campos[frequentouEducacaoInfantil]" :value="old('campos.frequentouEducacaoInfantil', $entrevistaFamiliar?->campos['frequentouEducacaoInfantil'] ?? '')" />
                <x-form.input label="Com quantos anos aprendeu a ler e escrever?" appearance="outlined" size="large"
                    name="campos[aprendeuLerEscrever]" :value="old('campos.aprendeuLerEscrever', $entrevistaFamiliar?->campos['aprendeuLerEscrever'] ?? '')" />
                <x-form.input label="Quais os cursos extra-escolares que já fez?" appearance="outlined" size="full"
                    name="campos[cursosExtraEscolares]" :value="old('campos.cursosExtraEscolares', $entrevistaFamiliar?->campos['cursosExtraEscolares'] ?? '')" />
                <x-form.input
                    label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?"
                    appearance="outlined" size="full" name="campos[atendimentoEduacionalEspecializado]" :value="old('campos.atendimentoEduacionalEspecializado', $entrevistaFamiliar?->campos['atendimentoEduacionalEspecializado'] ?? '')" />
                <x-form.input label="Foi necessária alguma Adaptação Curricular? Qual(is)?" appearance="outlined" size="full"
                    name="campos[adaptacaoCurricular]" :value="old('campos.adaptacaoCurricular', $entrevistaFamiliar?->campos['adaptacaoCurricular'] ?? '')" />
                <x-form.input label="Outras necessidades relatadas e/ou percebidas:" appearance="outlined" size="full"
                    name="campos[outrasNecessidades]" :value="old('campos.outrasNecessidades', $entrevistaFamiliar?->campos['outrasNecessidades'] ?? '')" />
                <x-form.input
                    label="Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela."
                    appearance="outlined" size="full" name="campos[potencialidades]" :value="old('campos.potencialidades', $entrevistaFamiliar?->campos['potencialidades'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="5. Desenvolvimento biopsicosocial" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Gestação planejada/desejada" appearance="outlined" size="large"
                    name="campos[gestacaoPlanejada]" :value="old('campos.gestacaoPlanejada', $entrevistaFamiliar?->campos['gestacaoPlanejada'] ?? '')" />
                <livewire:form.select label="Fez pré-natal" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[fezPreNatal]" :value="old('campos.fezPreNatal', $entrevistaFamiliar?->campos['fezPreNatal'] ?? '')" />
                <x-form.input label="Doenças apresentadas" appearance="outlined" size="full"
                    name="campos[doencasApresentadas]" :value="old('campos.doencasApresentadas', $entrevistaFamiliar?->campos['doencasApresentadas'] ?? '')" />
                <x-form.input label="Usou fraldas até que idade?" appearance="outlined" size="medium"
                    name="campos[usouFraldas]" :value="old('campos.usouFraldas', $entrevistaFamiliar?->campos['usouFraldas'] ?? '')" />
                <x-form.input
                    label="Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?"
                    appearance="outlined" size="large" name="campos[ateQueIdadeMamadeira]" :value="old('campos.ateQueIdadeMamadeira', $entrevistaFamiliar?->campos['ateQueIdadeMamadeira'] ?? '')" />
                <x-form.input
                    label="Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)"
                    appearance="outlined" size="full" name="campos[desenvolvimentoFalaAndar]" :value="old('campos.desenvolvimentoFalaAndar', $entrevistaFamiliar?->campos['desenvolvimentoFalaAndar'] ?? '')" />
                <x-form.input label="As indicações de vacinação foram cumpridas? Se não, por quê?" appearance="outlined" size="full"
                    name="campos[IndicacoesVacinacao]" :value="old('campos.IndicacoesVacinacao', $entrevistaFamiliar?->campos['IndicacoesVacinacao'] ?? '')" />
                <x-form.input label="Faz uso de medicamento" appearance="outlined" size="full"
                    name="campos[fazUsoMedicamento]" :value="old('campos.fazUsoMedicamento', $entrevistaFamiliar?->campos['fazUsoMedicamento'] ?? '')" />
                <x-form.input label="Seletividade ou restrição alimentar" appearance="outlined" size="full"
                    name="campos[seletividadeRestricaoAlimentar]" :value="old('campos.seletividadeRestricaoAlimentar', $entrevistaFamiliar?->campos['seletividadeRestricaoAlimentar'] ?? '')" />
                <x-form.input label="Internamentos e cirurgias" appearance="outlined" size="full"
                    name="campos[internamentosCirurgias]" :value="old('campos.internamentosCirurgias', $entrevistaFamiliar?->campos['internamentosCirurgias'] ?? '')" />
                <x-form.input
                    label="Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)"
                    appearance="outlined" size="full" name="campos[deficienciaTranstornos]" :value="old('campos.deficienciaTranstornos', $entrevistaFamiliar?->campos['deficienciaTranstornos'] ?? '')" />
                <x-form.input
                    label="Fez ou faz algum acompanhamento com profissional de Saúde externo?" appearance="outlined" size="full"
                    name="campos[acompanhamentoSaudeExterno]" :value="old('campos.acompanhamentoSaudeExterno', $entrevistaFamiliar?->campos['acompanhamentoSaudeExterno'] ?? '')" />
                <x-form.input label="Nome do fisioterapeuta" appearance="outlined" size="large"
                    name="campos[nomeFisioterapeuta]" :value="old('campos.nomeFisioterapeuta', $entrevistaFamiliar?->campos['nomeFisioterapeuta'] ?? '')" />
                <x-form.input label="Contato do fisioterapeuta" appearance="outlined" size="medium"
                    name="campos[contatoFisioterapeuta]" :value="old('campos.contatoFisioterapeuta', $entrevistaFamiliar?->campos['contatoFisioterapeuta'] ?? '')" />
                <x-form.input label="Nome do fonoaudiólogo" appearance="outlined" size="large"
                    name="campos[nomeFonoaudiologo]" :value="old('campos.nomeFonoaudiologo', $entrevistaFamiliar?->campos['nomeFonoaudiologo'] ?? '')" />
                <x-form.input label="Contato do fonoaudiólogo" appearance="outlined" size="medium"
                    name="campos[contatoFonoaudiologo]" :value="old('campos.contatoFonoaudiologo', $entrevistaFamiliar?->campos['contatoFonoaudiologo'] ?? '')" />
                <x-form.input label="Nome do psicólogo" appearance="outlined" size="large"
                    name="campos[nomePsicologo]" :value="old('campos.nomePsicologo', $entrevistaFamiliar?->campos['nomePsicologo'] ?? '')" />
                <x-form.input label="Contato do psicólogo" appearance="outlined" size="medium"
                    name="campos[contatoPsicologo]" :value="old('campos.contatoPsicologo', $entrevistaFamiliar?->campos['contatoPsicologo'] ?? '')" />
                <x-form.input label="Nome do neurologista" appearance="outlined" size="large"
                    name="campos[nomeNeurologista]" :value="old('campos.nomeNeurologista', $entrevistaFamiliar?->campos['nomeNeurologista'] ?? '')" />
                <x-form.input label="Contato do neurologista" appearance="outlined" size="medium"
                    name="campos[contatoNeurologista]" :value="old('campos.contatoNeurologista', $entrevistaFamiliar?->campos['contatoNeurologista'] ?? '')" />
                <x-form.input label="Observações" appearance="outlined" size="full" name="campos[observacoes]"
                    :value="old('campos.observacoes', $entrevistaFamiliar?->campos['observacoes'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="6. Características de comportamento do Estudante" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <livewire:form.select label="Timido?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[timido]" :value="old('campos.timido', $entrevistaFamiliar?->campos['timido'] ?? '')" />
                <livewire:form.select label="Extrovertido?" placeholder="Selecionar" appearance="outlined"
                    size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[extrovertido]" :value="old('campos.extrovertido', $entrevistaFamiliar?->campos['extrovertido'] ?? '')" />
                <livewire:form.select label="Persistente?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[persistente]" :value="old('campos.persistente', $entrevistaFamiliar?->campos['persistente'] ?? '')" />
                <livewire:form.select label="Calmo?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[calmo]" :value="old('campos.calmo', $entrevistaFamiliar?->campos['calmo'] ?? '')" />
                <livewire:form.select label="Agitado?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[agitado]" :value="old('campos.agitado', $entrevistaFamiliar?->campos['agitado'] ?? '')" />
                <livewire:form.select label="Ansioso?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[ansioso]" :value="old('campos.ansioso', $entrevistaFamiliar?->campos['ansioso'] ?? '')" />
                <livewire:form.select label="Organizado?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[organizado]" :value="old('campos.organizado', $entrevistaFamiliar?->campos['organizado'] ?? '')" />
                <livewire:form.select label="Perfeccionista?" placeholder="Selecionar" appearance="outlined"
                    size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[perfeccionista]" :value="old('campos.perfeccionista', $entrevistaFamiliar?->campos['perfeccionista'] ?? '')" />
                <livewire:form.select label="Responsável?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[responsavel]" :value="old('campos.responsavel', $entrevistaFamiliar?->campos['responsavel'] ?? '')" />
                <livewire:form.select label="Amoroso?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[amoroso]" :value="old('campos.amoroso', $entrevistaFamiliar?->campos['amoroso'] ?? '')" />
                <livewire:form.select label="Nervoso?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[nervoso]" :value="old('campos.nervoso', $entrevistaFamiliar?->campos['nervoso'] ?? '')" />
                <livewire:form.select label="Inseguro?" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[inseguro]" :value="old('campos.inseguro', $entrevistaFamiliar?->campos['inseguro'] ?? '')" />
                <x-form.input label="Outros" appearance="outlined" size="full" name="campos[outros]"
                    :value="old('campos.outros', $entrevistaFamiliar?->campos['outros'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="7. Informações Gerais e de âmbito escolar" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Origem e histórico do caso e dos atendimentos" appearance="outlined" size="full"
                    name="campos[origemHistorico]" :value="old('campos.origemHistorico', $entrevistaFamiliar?->campos['origemHistorico'] ?? '')" />
                <x-form.input label="Faz uso de algum artefato para mobilidade? Qual(is)?" appearance="outlined" size="full"
                    name="campos[artefatosMobilidade]" :value="old('campos.artefatosMobilidade', $entrevistaFamiliar?->campos['artefatosMobilidade'] ?? '')" />
                <x-form.input
                    label="Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)"
                    appearance="outlined" size="full" name="campos[adaptacaoMobiliario]" :value="old('campos.adaptacaoMobiliario', $entrevistaFamiliar?->campos['adaptacaoMobiliario'] ?? '')" />
                <x-form.input
                    label="É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?"
                    appearance="outlined" size="full" name="campos[necessidadeLocacao]" :value="old('campos.necessidadeLocacao', $entrevistaFamiliar?->campos['necessidadeLocacao'] ?? '')" />
                <x-form.input
                    label="Necessita de alguma adaptação para a utilização do computador? Qual?" appearance="outlined" size="full"
                    name="campos[adaptacaoComputador]" :value="old('campos.adaptacaoComputador', $entrevistaFamiliar?->campos['adaptacaoComputador'] ?? '')" />
                <x-form.input
                    label="Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?"
                    appearance="outlined" size="full" name="campos[transporteCampus]" :value="old('campos.transporteCampus', $entrevistaFamiliar?->campos['transporteCampus'] ?? '')" />
                <x-form.input
                    label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?"
                    appearance="outlined" size="full" name="campos[atendimentoEducativo]" :value="old('campos.atendimentoEducativo', $entrevistaFamiliar?->campos['atendimentoEducativo'] ?? '')" />
                <x-form.input label="Foi necessária alguma Adaptação Curricular? Qual(is)?" appearance="outlined" size="full"
                    name="campos[necessidadeAdaptacaoCurricular]" :value="old('campos.necessidadeAdaptacaoCurricular', $entrevistaFamiliar?->campos['necessidadeAdaptacaoCurricular'] ?? '')" />
                <x-form.input
                    label="Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros)"
                    appearance="outlined" size="large" name="campos[sistemaLinguistico]" :value="old('campos.sistemaLinguistico', $entrevistaFamiliar?->campos['sistemaLinguistico'] ?? '')" />
                <x-form.input
                    label="Recursos ou equipamentos de acessibilidade já usados pelo estudante:" appearance="outlined" size="full"
                    name="campos[recursosAcessibilidade]" :value="old('campos.recursosAcessibilidade', $entrevistaFamiliar?->campos['recursosAcessibilidade'] ?? '')" />
                <x-form.input label="Recursos ou equipamentos que necessitam ser providenciados:" appearance="outlined" size="full"
                    name="campos[recursosProvidenciados]" :value="old('campos.recursosProvidenciados', $entrevistaFamiliar?->campos['recursosProvidenciados'] ?? '')" />
                <x-form.input label="Outras necessidades relatadas e/ou percebidas:" appearance="outlined" size="full"
                    name="campos[outrasNecessidadesEscolares]" :value="old('campos.outrasNecessidadesEscolares', $entrevistaFamiliar?->campos['outrasNecessidadesEscolares'] ?? '')" />
                <x-form.input label="Sugestões para melhoria da adaptação" appearance="outlined" size="full"
                    name="campos[sugestoesAdaptacao]" :value="old('campos.sugestoesAdaptacao', $entrevistaFamiliar?->campos['sugestoesAdaptacao'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="Caso haja contato com a escola anterior" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Teve acompanhamento de AEE? Fez uso da sala de recurso?" appearance="outlined" size="full"
                    name="campos[acompanhamentoAEE]" :value="old('campos.acompanhamentoAEE', $entrevistaFamiliar?->campos['acompanhamentoAEE'] ?? '')" />
                <x-form.input label="Potencialidades e dificuldades acadêmicas" appearance="outlined" size="full"
                    name="campos[potencialidadesDificuldades]" :value="old('campos.potencialidadesDificuldades', $entrevistaFamiliar?->campos['potencialidadesDificuldades'] ?? '')" />
                <x-form.input label="Tinha material adaptado? Quais?" appearance="outlined" size="full"
                    name="campos[materialAdaptado]" :value="old('campos.materialAdaptado', $entrevistaFamiliar?->campos['materialAdaptado'] ?? '')" />
                <x-form.input label="Participou de apoio escolar? Qual?" appearance="outlined" size="full"
                    name="campos[apoioEscolar]" :value="old('campos.apoioEscolar', $entrevistaFamiliar?->campos['apoioEscolar'] ?? '')" />
                <x-form.input label="Algum comportamento diferenciado?" appearance="outlined" size="full"
                    name="campos[comportamentoDiferenciado]" :value="old('campos.comportamentoDiferenciado', $entrevistaFamiliar?->campos['comportamentoDiferenciado'] ?? '')" />
                <x-form.input label="Alguma questão de sensibilidade?" appearance="outlined" size="full"
                    name="campos[questaoSensibilidade]" :value="old('campos.questaoSensibilidade', $entrevistaFamiliar?->campos['questaoSensibilidade'] ?? '')" />
                <x-form.input label="Algum momento de crise? Que tipo?" appearance="outlined" size="full"
                    name="campos[momentoCrise]" :value="old('campos.momentoCrise', $entrevistaFamiliar?->campos['momentoCrise'] ?? '')" />
                <x-form.input label="Teve laudo por encaminhamento da escola?" appearance="outlined" size="large"
                    name="campos[laudoEscola]" :value="old('campos.laudoEscola', $entrevistaFamiliar?->campos['laudoEscola'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="Caso haja contato com profissionais externos" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <x-form.input label="Quando começou o tratamento?" appearance="outlined" size="large"
                    name="campos[inicioTratamento]" :value="old('campos.inicioTratamento', $entrevistaFamiliar?->campos['inicioTratamento'] ?? '')" />
                <x-form.input label="Por que começou?" appearance="outlined" size="full"
                    name="campos[porQueComecou]" :value="old('campos.porQueComecou', $entrevistaFamiliar?->campos['porQueComecou'] ?? '')" />
                <x-form.input label="Apresenta crises de comportamento?" appearance="outlined" size="full"
                    name="campos[apresentaCrisesComportamento]" :value="old('campos.apresentaCrisesComportamento', $entrevistaFamiliar?->campos['apresentaCrisesComportamento'] ?? '')" />
                <x-form.input label="Qual ou quais situações desencadeiam crises?" appearance="outlined" size="full"
                    name="campos[qualSituacoesDesencadeiamCrises]" :value="old('campos.qualSituacoesDesencadeiamCrises', $entrevistaFamiliar?->campos['qualSituacoesDesencadeiamCrises'] ?? '')" />
                <x-form.input label="Orientações para evitar estresse" appearance="outlined" size="full"
                    name="campos[orientacoesEvitarEstresse]" :value="old('campos.orientacoesEvitarEstresse', $entrevistaFamiliar?->campos['orientacoesEvitarEstresse'] ?? '')" />
                <x-form.input label="Quais as melhorias?" appearance="outlined" size="full"
                    name="campos[quaisMelhorias]" :value="old('campos.quaisMelhorias', $entrevistaFamiliar?->campos['quaisMelhorias'] ?? '')" />
                <x-form.input label="Maiores orientações para sala de aula e escola" appearance="outlined" size="full"
                    name="campos[maioresOrientacoes]" :value="old('campos.maioresOrientacoes', $entrevistaFamiliar?->campos['maioresOrientacoes'] ?? '')" />
                <x-form.input label="Necessita de abafador de som no ambiente escolar?" appearance="outlined" size="medium"
                    name="campos[necessitaAbafadorSom]" :value="old('campos.necessitaAbafadorSom', $entrevistaFamiliar?->campos['necessitaAbafadorSom'] ?? '')" />
                <x-form.input
                    label="Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?" appearance="outlined" size="full"
                    name="campos[comoSeOrganiza]" :value="old('campos.comoSeOrganiza', $entrevistaFamiliar?->campos['comoSeOrganiza'] ?? '')" />
                <x-form.input label="Como o estudante aprende?" appearance="outlined" size="full"
                    name="campos[comoAprende]" :value="old('campos.comoAprende', $entrevistaFamiliar?->campos['comoAprende'] ?? '')" />
                <x-form.input label="Quais recursos e/ou estratégias facilitam sua aprendizagem?" appearance="outlined" size="full"
                    name="campos[quaisRecursosFacilitam]" :value="old('campos.quaisRecursosFacilitam', $entrevistaFamiliar?->campos['quaisRecursosFacilitam'] ?? '')" />
                <x-form.input label="Quais recursos e/ou estratégias dificultam sua aprendizagem?" appearance="outlined" size="full"
                    name="campos[quaisRecursosDificultam]" :value="old('campos.quaisRecursosDificultam', $entrevistaFamiliar?->campos['quaisRecursosDificultam'] ?? '')" />
                <x-form.input
                    label="Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?" appearance="outlined" size="full"
                    name="campos[emQueAreaFacilidade]" :value="old('campos.emQueAreaFacilidade', $entrevistaFamiliar?->campos['emQueAreaFacilidade'] ?? '')" />
                <x-form.input
                    label="Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?" appearance="outlined" size="full"
                    name="campos[emQueAreaDificuldade]" :value="old('campos.emQueAreaDificuldade', $entrevistaFamiliar?->campos['emQueAreaDificuldade'] ?? '')" />
            </div>
        </x-secao-expansivel>
        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="estudantes.show" :args="['estudante' => $estudante]" />
            <x-button type="submit" :label="$entrevistaFamiliar ? 'Salvar' : 'Registrar'" />
        </div>
    </form>
</x-layouts.main>
