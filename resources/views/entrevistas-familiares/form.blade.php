@props(['entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;
?>

<x-layouts.main title="Entrevista Escolar Familiar">
    <form action="{{ route('estudantes.entrevistas-familiares.store', ['estudante' => $estudante?->id]) }}"
        method="POST">
        @csrf
        <x-secao-expansivel title="1. Identificação do Estudante" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <livewire:form.input type="date" label="Data da entrevista" appearance="outlined" size="small"
                    name="data" :value="$entrevistaFamiliar?->data->format('Y-m-d')" />
                <hr class="text-on-surface">
                <livewire:form.input type="text" label="Nome completo do estudante" appearance="outlined"
                    name="campos[nomeCompleto]" value="{{ old('campos.nomeCompleto') }}" />
                <livewire:form.input type="text" label="Nome social" appearance="outlined" size="small"
                    name="campos[nomeSocial]" value="{{ old('campos.nomeSocial') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="number" label="Idade" appearance="outlined" size="small"
                    name="campos[idade]" value="{{ old('campos.idade') }}" />
                <livewire:form.input type="date" label="Data de nascimento" appearance="outlined" size="small"
                    name="campos[dataNascimento]" value="{{ old('campos.dataNascimento') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="text" label="Nome completo da mãe" appearance="outlined"
                    name="campos[nomeMae]" value="{{ old('campos.nomeMae') }}" />
                <livewire:form.input type="text" label="Nome completo do pai" appearance="outlined"
                    name="campos[nomePai]" value="{{ old('campos.nomePai') }}" />
                <livewire:form.input type="text" label="Nome completo da responsável" appearance="outlined"
                    name="campos[nomeResponsavel]" value="{{ old('campos.nomeResponsavel') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="tel" label="Celular do estudante" appearance="outlined" size="small"
                    name="campos[celularEstudante]" value="{{ old('campos.celularEstudante') }}" />
                <livewire:form.input type="tel" label="Celular da mãe" appearance="outlined" size="small"
                    name="campos[celularMae]" value="{{ old('campos.celularMae') }}" />
                <livewire:form.input type="tel" label="Celular do pai" appearance="outlined" size="small"
                    name="campos[celularPai]" value="{{ old('campos.celularPai') }}" />
                <livewire:form.input type="tel" label="Celular fixo" appearance="outlined" size="small"
                    name="campos[celularFixo]" value="{{ old('campos.celularFixo') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="email" label="Email do estudante" appearance="outlined"
                    name="campos[emailEstudante]" value="{{ old('campos.emailEstudante') }}" />
                <livewire:form.input type="email" label="Email da mãe" appearance="outlined" name="campos[emailMae]"
                    value="{{ old('campos.emailMae') }}" />
                <livewire:form.input type="email" label="Email do pai" appearance="outlined" name="campos[emailPai]"
                    value="{{ old('campos.emailPai') }}" />
                <livewire:form.input type="email" label="Email do responsável" appearance="outlined"
                    name="campos[emailResponsavel]" value="{{ old('campos.emailResponsavel') }}" />
                <hr class="text-on-surface">
                <livewire:form.select label="Pode ser chamado SAMU?" placeholder="Selecionar" appearance="outlined"
                    name="campos[podeSerChamadoSAMU]" :options="['Sim' => 'Sim', 'Não' => 'Não']"
                    value="{{ old('campos.podeSerChamadoSAMU') }}" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="2. Identificação do curso" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <livewire:form.input type="text" label="Nome do curso" appearance="outlined"
                    name="campos[nomeCurso]" value="{{ old('campos.nomeCurso') }}" />
                <livewire:form.select label="Forma de oferta" placeholder="Selecionar" appearance="outlined"
                    size="small" :options="[
                        'FIC' => 'FIC',
                        'Proeja' => 'Proeja',
                        'Integrado' => 'Integrado',
                        'Subsequente' => 'Subsequente',
                        'Graduação - Licenciatura' => 'Graduação - Licenciatura',
                        'Graduação - Bacharelado' => 'Graduação - Bacharelado',
                        'Graduação - Tecnólogo' => 'Graduação - Tecnólogo',
                        'Especialização' => 'Especialização',
                        'Mestrado' => 'Mestrado',
                    ]" name="campos[formaOferta]"
                    value="{{ old('campos.formaOferta') }}" />
                <livewire:form.input type="number" label="Matricula" appearance="outlined" name="campos[matricula]"
                    value="{{ old('campos.matricula') }}" />
                <livewire:form.select label="Turno" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="['Matutino' => 'Matutino', 'Vespertino' => 'Vespertino', 'Noturno' => 'Noturno']" name="campos[turno]" value="{{ old('campos.turno') }}" />
                <livewire:form.input type="number" label="Ano/Período" appearance="outlined" size="small"
                    name="campos[anoPeriodo]" value="{{ old('campos.anoPeriodo') }}" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="3. Cota de Ingresso" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <livewire:form.select label="Cota" placeholder="Selecionar" appearance="outlined" size="small"
                    :options="[
                        'PNE' => 'PNE',
                        'Pretos ou Pardos' => 'Pretos ou Pardos',
                        'Indígenas' => 'Indígenas',
                        'Entrada por sorteio público' => 'Entrada por sorteio público',
                        'Social' => 'Social',
                        'Escola Pública' => 'Escola Pública',
                        'Ampla Concorrência' => 'Ampla Concorrência',
                        'Quilombola' => 'Quilombola',
                    ]" name="campos[cota]" value="{{ old('campos.cota') }}" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="4. Informações Familiares" class="mb-5">
            <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
                <livewire:form.input type="text" label="Formação da mãe" appearance="outlined"
                    name="campos[formacaoMae]" value="{{ old('campos.formacaoMae') }}" />
                <livewire:form.input type="text" label="Profissão da mãe" appearance="outlined"
                    name="campos[profissaoMae]" value="{{ old('campos.profissaoMae') }}" />
                <livewire:form.input type="number" label="Idade da mãe" appearance="outlined" size="small"
                    name="campos[idadeMae]" value="{{ old('campos.idadeMae') }}" />
                <livewire:form.input type="text" label="A mãe está atualmente empregada?" appearance="outlined"
                    name="campos[maeEmpregada]" value="{{ old('campos.maeEmpregada') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="text" label="Formação do pai" appearance="outlined"
                    name="campos[formacaoPai]" value="{{ old('campos.formacaoPai') }}" />
                <livewire:form.input type="text" label="Profissão do pai" appearance="outlined"
                    name="campos[profissaoPai]" value="{{ old('campos.profissaoPai') }}" />
                <livewire:form.input type="number" label="Idade do pai" appearance="outlined" size="small"
                    name="campos[idadePai]" value="{{ old('campos.idadePai') }}" />
                <livewire:form.input type="text" label="O pai está atualmente empregado?" appearance="outlined"
                    name="campos[paiEmpregado]" value="{{ old('campos.paiEmpregado') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="text" label="Formação do responsável" appearance="outlined"
                    name="campos[formacaoResponsavel]" value="{{ old('campos.formacaoResponsavel') }}" />
                <livewire:form.input type="text" label="Profissão do responsável" appearance="outlined"
                    name="campos[profissaoResponsavel]" value="{{ old('campos.profissaoResponsavel') }}" />
                <livewire:form.input type="number" label="Idade do responsável" appearance="outlined"
                    size="small" name="campos[idadeResponsavel]" value="{{ old('campos.idadeResponsavel') }}" />
                <livewire:form.input type="text" label="O responsável está atualmente empregado?"
                    appearance="outlined" name="campos[responsavelEmpregado]"
                    value="{{ old('campos.responsavelEmpregado') }}" />
                <hr class="text-on-surface">
                <livewire:form.input type="text" label="Número de irmãos" appearance="outlined"
                    name="campos[numeroIrmaos]" value="{{ old('campos.numeroIrmaos') }}" />
                <livewire:form.input type="text" label="Estudante mora com" appearance="outlined"
                    name="campos[moraCom]" value="{{ old('campos.moraCom') }}" />
                <livewire:form.select label="Pais separados?" placeholder="Selecionar" appearance="outlined"
                    size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[paisSeparados]"
                    value="{{ old('campos.paisSeparados') }}" />
                <livewire:form.select label="Alguma pessoa da família tem deficiência?" placeholder="Selecionar"
                    appearance="outlined" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[deficiencia]"
                    value="{{ old('campos.deficiencia') }}" />
                <livewire:form.input type="text" label="Se sim, qual?" appearance="outlined"
                    name="campos[tipoDeficiencia]" value="{{ old('campos.tipoDeficiencia') }}" />
                <livewire:form.input type="text"
                    label="Rotina diária antes e depois das aulas/atividades domésticas" appearance="outlined"
                    name="campos[rotinaDiaria]" value="{{ old('campos.rotinaDiaria') }}" />
                <livewire:form.input type="text" label="Relacionamento com familiares" appearance="outlined"
                    name="campos[relacionamentoFamiliares]" value="{{ old('campos.relacionamentoFamiliares') }}" />
                <livewire:form.input type="text" label="Com quem mais convive fora da escola?"
                    appearance="outlined" name="campos[comQuemConvive]"
                    value="{{ old('campos.comQuemConvive') }}" />
                <livewire:form.input type="text" label="Mantém amizades com pessoas da mesma idade"
                    appearance="outlined" name="campos[mantemAmizades]"
                    value="{{ old('campos.mantemAmizades') }}" />
                <livewire:form.input type="text" label="A família se reúne para atividades de lazer? Que tipo?"
                    appearance="outlined" name="campos[atividadesLazer]"
                    value="{{ old('campos.atividadesLazer') }}" />
                <livewire:form.input type="text" label="Condições de moradia (casa própria, alugada, outro)"
                    appearance="outlined" name="campos[condicoesMoradia]"
                    value="{{ old('campos.condicoesMoradia') }}" />
                <livewire:form.input type="text" label="Tem ambiente específico para estudo? Como é?"
                    appearance="outlined" name="campos[ambienteEstudo]"
                    value="{{ old('campos.ambienteEstudo') }}" />
                <livewire:form.input type="text"
                    label="Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?"
                    appearance="outlined" name="campos[acompanhamento]"
                    value="{{ old('campos.acompanhamento') }}" />
                <livewire:form.input type="text"
                    label="Qual é o local da casa onde o estudante permanece mais tempo?" appearance="outlined"
                    name="campos[localPermanencia]" value="{{ old('campos.localPermanencia') }}" />
            </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="5. História Escolar do Estudante" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.input type="text" label="Qual a escola de origem?" appearance="outlined"
                name="campos[escolaOrigem]" value="{{ old('campos.escolaOrigem') }}" />
            <livewire:form.input type="text" label="Há quanto tempo no IFPR?" appearance="outlined"
                name="campos[tempoIFPR]" value="{{ old('campos.tempoIFPR') }}" />
            <livewire:form.input type="text" label="Já reprovou algum ano escolar? Qual? Motivo?"
                appearance="outlined" name="campos[reprovacao]" value="{{ old('campos.reprovacao') }}" />
            <livewire:form.input type="text"
                label="Áreas de conhecimento com as quais têm mais facilidade na escola" appearance="outlined"
                name="campos[areasFacilidade]" value="{{ old('campos.areasFacilidade') }}" />
            <livewire:form.input type="text"
                label="Áreas de conhecimento com as quais têm mais dificuldade na escola" appearance="outlined"
                name="campos[areasDificuldade]" value="{{ old('campos.areasDificuldade') }}" />
            <livewire:form.input type="text"
                label="Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes)"
                appearance="outlined" name="campos[trajetoriaEscolar]"
                value="{{ old('campos.trajetoriaEscolar') }}" />
            <livewire:form.input type="text" label="Frequentou educação infantil a partir de que idade?"
                appearance="outlined" name="campos[frequentouEducacaoInfantil]"
                value="{{ old('campos.frequentouEducacaoInfantil') }}" />
            <livewire:form.input type="text" label="Com quantos anos aprendeu a ler e escrever?"
                appearance="outlined" name="campos[aprendeuLerEscrever]"
                value="{{ old('campos.aprendeuLerEscrever') }}" />
            <livewire:form.input type="text" label="Quais os cursos extra-escolares que já fez?"
                appearance="outlined" name="campos[cursosExtraEscolares]"
                value="{{ old('campos.cursosExtraEscolares') }}" />
            <livewire:form.input type="text"
                label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?"
                appearance="outlined" name="campos[atendimentoEduacionalEspecializado]"
                value="{{ old('campos.atendimentoEduacionalEspecializado') }}" />
            <livewire:form.input type="text" label="Foi necessária alguma Adaptação Curricular? Qual(is)?"
                appearance="outlined" name="campos[adaptacaoCurricular]"
                value="{{ old('campos.adaptacaoCurricular') }}" />
            <livewire:form.input type="text" label="Outras necessidades relatadas e/ou percebidas:"
                appearance="outlined" name="campos[outrasNecessidades]"
                value="{{ old('campos.outrasNecessidades') }}" />
            <livewire:form.input type="text"
                label="Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela."
                appearance="outlined" name="campos[potencialidades]" value="{{ old('campos.potencialidades') }}" />
        </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="6. Desenvolvimento biopsicosocial" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.input type="text" label="Gestação planejada/desejada" appearance="outlined"
                name="campos[gestacaoPlanejada]" value="{{ old('campos.gestacaoPlanejada') }}" />
            <livewire:form.select label="Fez pré-natal" placeholder="Selecionar" appearance="outlined"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[fezPreNatal]" value="{{ old('campos.fezPreNatal') }}" />
            <livewire:form.input type="text" label="Doenças apresentadas" appearance="outlined"
                name="campos[doencasApresentadas]" value="{{ old('campos.doencasApresentadas') }}" />
            <livewire:form.input type="text" label="Usou fraldas até que idade?" appearance="outlined"
                name="campos[usouFraldas]" value="{{ old('campos.usouFraldas') }}" />
            <livewire:form.input type="text"
                label="Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?"
                appearance="outlined" name="campos[ateQueIdadeMamadeira]"
                value="{{ old('campos.ateQueIdadeMamadeira') }}" />
            <livewire:form.input type="text"
                label="Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)"
                appearance="outlined" name="campos[desenvolvimentoFalaAndar]"
                value="{{ old('campos.desenvolvimentoFalaAndar') }}" />
            <livewire:form.input type="text" label="As indicações de vacinação foram cumpridas? Se não, por quê?"
                appearance="outlined" name="campos[IndicacoesVacinacao]"
                value="{{ old('campos.IndicacoesVacinacao') }}" />
            <livewire:form.input type="text" label="Faz uso de medicamento" appearance="outlined"
                name="campos[fazUsoMedicamento]" value="{{ old('campos.fazUsoMedicamento') }}" />
            <livewire:form.input type="text" label="Seletividade ou restrição alimentar" appearance="outlined"
                name="campos[seletividadeRestricaoAlimentar]"
                value="{{ old('campos.seletividadeRestricaoAlimentar') }}" />
            <livewire:form.input type="text" label="Internamentos e cirurgias" appearance="outlined"
                name="campos[internamentosCirurgias]" value="{{ old('campos.internamentosCirurgias') }}" />
            <livewire:form.input type="text"
                label="Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)"
                appearance="outlined" name="campos[deficienciaTranstornos]"
                value="{{ old('campos.deficienciaTranstornos') }}" />
            <livewire:form.input type="text"
                label="Fez ou faz algum acompanhamento com profissional de Saúde externo?" appearance="outlined"
                name="campos[acompanhamentoSaudeExterno]" value="{{ old('campos.acompanhamentoSaudeExterno') }}" />
            <livewire:form.input type="text" label="Nome do fisioterapeuta" appearance="outlined"
                name="campos[nomeFisioterapeuta]" value="{{ old('campos.nomeFisioterapeuta') }}" />
            <livewire:form.input type="text" label="Contato do fisioterapeuta" appearance="outlined"
                name="campos[contatoFisioterapeuta]" value="{{ old('campos.contatoFisioterapeuta') }}" />
            <livewire:form.input type="text" label="Nome do fonoaudiólogo" appearance="outlined"
                name="campos[nomeFonoaudiologo]" value="{{ old('campos.nomeFonoaudiologo') }}" />
            <livewire:form.input type="text" label="Contato do fonoaudiólogo" appearance="outlined"
                name="campos[contatoFonoaudiologo]" value="{{ old('campos.contatoFonoaudiologo') }}" />
            <livewire:form.input type="text" label="Nome do psicólogo" appearance="outlined"
                name="campos[nomePsicologo]" value="{{ old('campos.nomePsicologo') }}" />
            <livewire:form.input type="text" label="Contato do psicólogo" appearance="outlined"
                name="campos[contatoPsicologo]" value="{{ old('campos.contatoPsicologo') }}" />
            <livewire:form.input type="text" label="Nome do neurologista" appearance="outlined"
                name="campos[nomeNeurologista]" value="{{ old('campos.nomeNeurologista') }}" />
            <livewire:form.input type="text" label="Contato do neurologista" appearance="outlined"
                name="campos[contatoNeurologista]" value="{{ old('campos.contatoNeurologista') }}" />
            <livewire:form.input type="text" label="Observações" appearance="outlined" name="campos[observacoes]"
                value="{{ old('campos.observacoes') }}" />
        </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="7. Características de comportamento do Estudante" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.select label="Timido?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[timido]" value="{{ old('campos.timido') }}" />
            <livewire:form.select label="Extrovertido?" placeholder="Selecionar" appearance="outlined"
                size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[extrovertido]"
                value="{{ old('campos.extrovertido') }}" />
            <livewire:form.select label="Persistente?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[persistente]" value="{{ old('campos.persistente') }}" />
            <livewire:form.select label="Calmo?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[calmo]" value="{{ old('campos.calmo') }}" />
            <livewire:form.select label="Agitado?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[agitado]" value="{{ old('campos.agitado') }}" />
            <livewire:form.select label="Ansioso?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[ansioso]" value="{{ old('campos.ansioso') }}" />
            <livewire:form.select label="Organizado?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[organizado]" value="{{ old('campos.organizado') }}" />
            <livewire:form.select label="Perfeccionista?" placeholder="Selecionar" appearance="outlined"
                size="small" :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[perfeccionista]"
                value="{{ old('campos.perfeccionista') }}" />
            <livewire:form.select label="Responsável?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[responsavel]" value="{{ old('campos.responsavel') }}" />
            <livewire:form.select label="Amoroso?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[amoroso]" value="{{ old('campos.amoroso') }}" />
            <livewire:form.select label="Nervoso?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[nervoso]" value="{{ old('campos.nervoso') }}" />
            <livewire:form.select label="Inseguro?" placeholder="Selecionar" appearance="outlined" size="small"
                :options="['Sim' => 'Sim', 'Não' => 'Não']" name="campos[inseguro]" value="{{ old('campos.inseguro') }}" />
            <livewire:form.input type="text" label="Outros" appearance="outlined" name="campos[outros]"
                value="{{ old('campos.outros') }}" />
        </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="8. Informações Gerais e de âmbito escolar" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.input type="text" label="Origem e histórico do caso e dos atendimentos"
                appearance="outlined" name="campos[origemHistorico]" value="{{ old('campos.origemHistorico') }}" />
            <livewire:form.input type="text" label="Faz uso de algum artefato para mobilidade? Qual(is)?"
                appearance="outlined" name="campos[artefatosMobilidade]"
                value="{{ old('campos.artefatosMobilidade') }}" />
            <livewire:form.input type="text"
                label="Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)"
                appearance="outlined" name="campos[adaptacaoMobiliario]"
                value="{{ old('campos.adaptacaoMobiliario') }}" />
            <livewire:form.input type="text"
                label="É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?"
                appearance="outlined" name="campos[necessidadeLocacao]"
                value="{{ old('campos.necessidadeLocacao') }}" />
            <livewire:form.input type="text"
                label="Necessita de alguma adaptação para a utilização do computador? Qual?" appearance="outlined"
                name="campos[adaptacaoComputador]" value="{{ old('campos.adaptacaoComputador') }}" />
            <livewire:form.input type="text"
                label="Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?"
                appearance="outlined" name="campos[transporteCampus]"
                value="{{ old('campos.transporteCampus') }}" />
            <livewire:form.input type="text"
                label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?"
                appearance="outlined" name="campos[atendimentoEducativo]"
                value="{{ old('campos.atendimentoEducativo') }}" />
            <livewire:form.input type="text" label="Foi necessária alguma Adaptação Curricular? Qual(is)?"
                appearance="outlined" name="campos[necessidadeAdaptacaoCurricular]"
                value="{{ old('campos.necessidadeAdaptacaoCurricular') }}" />
            <livewire:form.input type="text"
                label="Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros)"
                appearance="outlined" name="campos[sistemaLinguistico]"
                value="{{ old('campos.sistemaLinguistico') }}" />
            <livewire:form.input type="text"
                label="Recursos ou equipamentos de acessibilidade já usados pelo estudante:" appearance="outlined"
                name="campos[recursosAcessibilidade]" value="{{ old('campos.recursosAcessibilidade') }}" />
            <livewire:form.input type="text" label="Recursos ou equipamentos que necessitam ser providenciados:"
                appearance="outlined" name="campos[recursosProvidenciados]"
                value="{{ old('campos.recursosProvidenciados') }}" />
            <livewire:form.input type="text" label="Outras necessidades relatadas e/ou percebidas:"
                appearance="outlined" name="campos[outrasNecessidadesEscolares]"
                value="{{ old('campos.outrasNecessidadesEscolares') }}" />
            <livewire:form.input type="text" label="Sugestões para melhoria da adaptação" appearance="outlined"
                name="campos[sugestoesAdaptacao]" value="{{ old('campos.sugestoesAdaptacao') }}" />
        </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="Caso haja contato com a escola anterior" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.input type="text" label="Teve acompanhamento de AEE? Fez uso da sala de recurso?"
                appearance="outlined" name="campos[acompanhamentoAEE]"
                value="{{ old('campos.acompanhamentoAEE') }}" />
            <livewire:form.input type="text" label="Potencialidades e dificuldades acadêmicas"
                appearance="outlined" name="campos[potencialidadesDificuldades]"
                value="{{ old('campos.potencialidadesDificuldades') }}" />
            <livewire:form.input type="text" label="Tinha material adaptado? Quais?" appearance="outlined"
                name="campos[materialAdaptado]" value="{{ old('campos.materialAdaptado') }}" />
            <livewire:form.input type="text" label="Participou de apoio escolar? Qual?" appearance="outlined"
                name="campos[apoioEscolar]" value="{{ old('campos.apoioEscolar') }}" />
            <livewire:form.input type="text" label="Algum comportamento diferenciado?" appearance="outlined"
                name="campos[comportamentoDiferenciado]" value="{{ old('campos.comportamentoDiferenciado') }}" />
            <livewire:form.input type="text" label="Alguma questão de sensibilidade?" appearance="outlined"
                name="campos[questaoSensibilidade]" value="{{ old('campos.questaoSensibilidade') }}" />
            <livewire:form.input type="text" label="Algum momento de crise? Que tipo?" appearance="outlined"
                name="campos[momentoCrise]" value="{{ old('campos.momentoCrise') }}" />
            <livewire:form.input type="text" label="Teve laudo por encaminhamento da escola?"
                appearance="outlined" name="campos[laudoEscola]" value="{{ old('campos.laudoEscola') }}" />
        </div>
        </x-secao-expansivel>
        <x-secao-expansivel title="Caso haja contato com profissionais externos" class="mb-5">
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
            <livewire:form.input type="text" label="Quando começou o tratamento?" appearance="outlined"
                name="campos[inicioTratamento]" value="{{ old('campos.inicioTratamento') }}" />
            <livewire:form.input type="text" label="Por que começou?" appearance="outlined"
                name="campos[porQueComecou]" value="{{ old('campos.porQueComecou') }}" />
            <livewire:form.input type="text" label="Apresenta crises de comportamento?" appearance="outlined"
                name="campos[apresentaCrisesComportamento]"
                value="{{ old('campos.apresentaCrisesComportamento') }}" />
            <livewire:form.input type="text" label="Qual ou quais situações desencadeiam crises?"
                appearance="outlined" name="campos[qualSituacoesDesencadeiamCrises]"
                value="{{ old('campos.qualSituacoesDesencadeiamCrises') }}" />
            <livewire:form.input type="text" label="Orientações para evitar estresse" appearance="outlined"
                name="campos[orientacoesEvitarEstresse]" value="{{ old('campos.orientacoesEvitarEstresse') }}" />
            <livewire:form.input type="text" label="Quais as melhorias?" appearance="outlined"
                name="campos[quaisMelhorias]" value="{{ old('campos.quaisMelhorias') }}" />
            <livewire:form.input type="text" label="Maiores orientações para sala de aula e escola"
                appearance="outlined" name="campos[maioresOrientacoes]"
                value="{{ old('campos.maioresOrientacoes') }}" />
            <livewire:form.input type="text" label="Necessita de abafador de som no ambiente escolar?"
                appearance="outlined" name="campos[necessitaAbafadorSom]"
                value="{{ old('campos.necessitaAbafadorSom') }}" />
            <livewire:form.input type="text"
                label="Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?"
                appearance="outlined" name="campos[comoSeOrganiza]" value="{{ old('campos.comoSeOrganiza') }}" />
            <livewire:form.input type="text" label="Como o estudante aprende?" appearance="outlined"
                name="campos[comoAprende]" value="{{ old('campos.comoAprende') }}" />
            <livewire:form.input type="text" label="Quais recursos e/ou estratégias facilitam sua aprendizagem?"
                appearance="outlined" name="campos[quaisRecursosFacilitam]"
                value="{{ old('campos.quaisRecursosFacilitam') }}" />
            <livewire:form.input type="text" label="Quais recursos e/ou estratégias dificultam sua aprendizagem?"
                appearance="outlined" name="campos[quaisRecursosDificultam]"
                value="{{ old('campos.quaisRecursosDificultam') }}" />
            <livewire:form.input type="text"
                label="Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?"
                appearance="outlined" name="campos[emQueAreaFacilidade]"
                value="{{ old('campos.emQueAreaFacilidade') }}" />
            <livewire:form.input type="text"
                label="Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?"
                appearance="outlined" name="campos[emQueAreaDificuldade]"
                value="{{ old('campos.emQueAreaDificuldade') }}" />
        </div>
        </x-secao-expansivel>
        <div class="flex justify-end gap-2">
            <x-button type="submit" label="Registrar" />
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
</x-layouts.main>
