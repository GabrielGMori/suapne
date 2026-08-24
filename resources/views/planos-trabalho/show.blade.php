<x-layouts.main title="{{ $planoTrabalho->nome }}">
    <div>
        <div class="flex justify-between items-center">
            <div>
                <h2 class="flex items-center gap-5 mb-5 text-display-small">Adaptação e/ou flexibilização
                    curricular</h2>
                <x-status label="{{ $planoTrabalho->status->label() }}" color="{{ $planoTrabalho->status->color() }}"
                          :filled="false"/>
            </div>
            @if($planoTrabalho->status === App\Enums\StatusPlanoTrabalhoEnum::APROVADO)
                <x-button label="Exportar como PDF" icon="file_export" iconPos="right" color="tertiary"/>
            @endif
        </div>
        <h4 class="mb-5">Período de realização: {{ $planoTrabalho->periodo_inicio->format('d/m/Y') }}
            a {{ $planoTrabalho->periodo_fim->format('d/m/Y') }}</h4>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <p>Nome: {{ $planoTrabalho->estudante->nome }}</p>
            <p>Curso/Turma: {{ $planoTrabalho->estudante->curso->nome }}</p>
            <p>Série/Ano: {{ $planoTrabalho->estudante->periodo }}</p>
            <p>Componente curricular: {{ $planoTrabalho->disciplina->nome }}</p>
            <p>Docente: {{ $planoTrabalho->professor->nome }}</p>
            <p>Carga horária de atendimento individualizado (se necessário): ---</p>
            <p>Dia/Horário/Local: {{ $planoTrabalho->created_at->format('d/m/Y h:i') }} CNAPNE</p>

            <p>Necessidade educacional específica:</p>
            <livewire:form.input disabled type="textarea" name="adaptacaopedagogica_outlined" appearance="outlined"
                                 size="full" class="bg-surface" value="O aluno possui..."/>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Particularidades do estudante</h2>
            <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                 appearance="outlined" size="full" class="bg-surface"
                                 value="Atendimentos e recursos utilizados pelo estudante..."/>
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">3. Conteúdos do componente curricular que necessitam de adaptação e/ou
                flexibilização:
                <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Ementa da disciplina preenchida automaticamente..."/>
            </h2>
        </div>


        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">4. Objetivos específicos para o estudante neste período
                <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Preenchido pelo professor"/>
            </h2>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">4. Objetivos específicos para o estudante neste período
                <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Preenchido pelo professor"/>
            </h2>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">5. Instrumentos avaliativos pretendidos e procedimentos adotados:</h2>
            <p>(De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)</p>
            <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                 appearance="outlined" size="full" class="bg-surface"
                                 value="Preenchido pelo professor"/>
        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">6. Outras considerações relevantes:</h2>

            <livewire:form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                 appearance="outlined" size="full" class="bg-surface"
                                 value="Preenchido pelo professor"/>
        </div>

        <div class="flex justify-end gap-2">
            <x-button label="Voltar" type="link"
                      href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-trabalho.index')  }}"
                      color="tertiary"/>
            @if($planoTrabalho->status === App\Enums\StatusPlanoTrabalhoEnum::DEVOLVIDO)
                <x-button label="Reavaliar" type="link" href="{{ route('planos-trabalho.index') }}" color="yellow"/>
            @elseif($planoTrabalho->status === App\Enums\StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)
                <x-button label="Devolver para retificação" color="red"/>
                <x-button label="Aprovar"/>
            @elseif($planoTrabalho->status === App\Enums\StatusPlanoTrabalhoEnum::APROVADO)
            @endif
        </div>
    </div>
</x-layouts.main>

