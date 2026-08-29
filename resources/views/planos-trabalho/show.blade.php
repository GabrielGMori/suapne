@props(['planoTrabalho', 'preview' => false, 'previewDisciplinas' => [], 'previewProfessores' => []])

@php
    use App\Enums\RoleEnum;
    use App\Enums\StatusPlanoTrabalhoEnum;

    $isProfessorRegular = Auth::user()->role === RoleEnum::PROFESSOR_REGULAR;
    $preenchendo = !$preview && $isProfessorRegular
                    && ($planoTrabalho->status === StatusPlanoTrabalhoEnum::DEVOLVIDO || $planoTrabalho->status === StatusPlanoTrabalhoEnum::PENDENTE);

    $created_at = $planoTrabalho->created_at ?? now();
    $updated_at = $planoTrabalho->updated_at ?? $created_at;
@endphp

<x-layouts.main title="{{ $planoTrabalho->nome }}">
    @if ($preenchendo)
        <form action="{{ route('planos-trabalho.update', ['plano_trabalho' => $planoTrabalho]) }}" method="POST">
            @method('PUT')
            @csrf
            <input type="hidden" name="status" value="AGUARDANDO_REVISAO">
    @endif
        <div>
            <div class="flex justify-between items-start mb-5">
                <div class="flex items-end gap-5">
                    <h2 class="flex gap-5 text-display-small">Adaptação e/ou flexibilização curricular</h2>
                    <x-status label="{{ $preview ? 'Pré-visualização' : $planoTrabalho->status->label() }}"
                        color="{{ $preview ? 'tertiary' : $planoTrabalho->status->color() }}" :filled="false" />
                </div>

                @if($planoTrabalho->status === StatusPlanoTrabalhoEnum::APROVADO)
                    <x-button label="Exportar como PDF" icon="file_export" iconPos="right" color="tertiary" target="_blank"
                            type="link" href="{{ route('planos-trabalho.export-pdf', ['planoTrabalho' => $planoTrabalho]) }}" />

                @elseif ($preview)
                    @include('planos-trabalho.change-preview', [
                        'planoTrabalho' => $planoTrabalho,
                        'previewDisciplinas' => $previewDisciplinas,
                        'previewProfessores' => $previewProfessores,
                    ])
                @endif
            </div>

            @if ($planoTrabalho->status === StatusPlanoTrabalhoEnum::DEVOLVIDO && array_key_exists('devolvidoObservacao', $planoTrabalho->campos))
                <hr class="mt-3 mb-10 text-on-surface">
                <h3 class="text-display-small">Observação adicionada na devolução:</h3>
                <p class="my-5 text-body-large whitespace-pre-line">{{ $planoTrabalho->campos['devolvidoObservacao'] }}</p>
                <hr class="mt-10 mb-5 text-on-surface">
            @endif

            <h4 class="mb-5">Período de realização: {{ $planoTrabalho->periodo_inicio->format('d/m/Y') }}
                a {{ $planoTrabalho->periodo_fim->format('d/m/Y') }}</h4>

            <div class="flex flex-col bg-surface rounded-lg gap-1 mb-5 p-5">
                <h2 class="text-display-small mb-5">1. Dados do estudante</h2>
                <p>Nome: {{ $planoTrabalho->estudante->nome }}</p>
                <p>Curso/Turma: {{ $planoTrabalho->estudante->curso->nome }}</p>
                <p>Série/Ano: {{ $planoTrabalho->estudante->periodo }}</p>
                <p>Componente curricular: {{ $planoTrabalho->disciplina->nome }}</p>
                <p>Docente: {{ $planoTrabalho->professor->nome }}</p>
                <p>Carga horária de atendimento individualizado:
                    {{ $planoTrabalho->campos['cargaHoraria'] ?? '---' }}
                </p>
                <p>Dia/Horário/Local: {{ $created_at->format('d/m/Y \à\s h:i ') . $planoTrabalho->campos['local'] }}</p>

                <p class="mt-5">Necessidade educacional específica:</p>
                <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
                    <p class="whitespace-pre-line">{{$planoTrabalho->estudante->necessidades}}</p>
                </div>
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">2. Particularidades do estudante</h2>
                <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
                    <p class="whitespace-pre-line">{{$planoTrabalho->campos['particularidadesEstudante']}}</p>
                </div>
            </div>
            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">3. Conteúdos do componente curricular que necessitam de adaptação e/ou
                    flexibilização:</h2>
                <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
                    <p class="whitespace-pre-line">{{$planoTrabalho->disciplina->ementa}}</p>
                </div>
            </div>


            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">4. Objetivos específicos para o estudante neste período</h2>

                @if(!$preenchendo)
                    <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5
                                    {{ array_key_exists('objetivosEspecificos', $planoTrabalho->campos) ? '' : 'italic' }}">
                        <p class="whitespace-pre-line">{{ $planoTrabalho->campos['objetivosEspecificos'] ?? 'A ser preenchido pelo docente...' }}</p>
                    </div>
                @else
                    <x-form.input type="textarea" name="campos[objetivosEspecificos]" appearance="outlined" size="full"
                        placeholder="Preencha aqui..." :value="$planoTrabalho->campos['objetivosEspecificos'] ?? ''" />
                @endif
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">5. Instrumentos avaliativos pretendidos e procedimentos adotados:</h2>
                <p>(De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)</p>

                @if(!$preenchendo)
                    <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5
                                    {{ array_key_exists('instrumentosAvaliativos', $planoTrabalho->campos) ? '' : 'italic' }}">
                        <p class="whitespace-pre-line">{{ $planoTrabalho->campos['instrumentosAvaliativos'] ?? 'A ser preenchido pelo docente...' }}</p>
                    </div>
                @else
                    <x-form.input type="textarea" name="campos[instrumentosAvaliativos]" appearance="outlined" size="full"
                        placeholder="Preencha aqui..." :value="$planoTrabalho->campos['instrumentosAvaliativos'] ?? ''" />
                @endif
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">6. Outras considerações relevantes:</h2>

                @if(!$preenchendo)
                    <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5
                                    {{ array_key_exists('outrasConsideracoes', $planoTrabalho->campos) ? '' : 'italic' }}">
                        <p class="whitespace-pre-line">{{ $planoTrabalho->campos['outrasConsideracoes'] ?? ($planoTrabalho->status === StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO ? '---' : 'A ser preenchido pelo docente...') }}
                        </p>
                    </div>
                @else
                    <x-form.input type="textarea" name="campos[outrasConsideracoes]" appearance="outlined" size="full"
                        placeholder="Preencha aqui..." :value="$planoTrabalho->campos['outrasConsideracoes'] ?? ''" />
                @endif
            </div>

            <p>Atualizado pela última vez: {{ $updated_at->format('d/m/Y \à\s H:i') }}</p>

            <div class="flex justify-end gap-2">
                @if($preview)
                    <x-button label="Voltar" color="tertiary" type="button" onclick="window.close()" />
                @else
                    <x-button.cancel label="Voltar" color="tertiary" fallback="planos-trabalho.index" />
                @endif

                @switch($planoTrabalho->status)
                    @case(StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)
                    @case(StatusPlanoTrabalhoEnum::APROVADO)
                        @if (!$isProfessorRegular)
                            <livewire:modal.stateful.revisar-plano-trabalho :plano-trabalho="$planoTrabalho" />
                        @endif
                    @break

                    @default
                        @if ($preenchendo)
                            <x-button label="Salvar preenchimento" type="submit" size="dynamic" />
                        @endif
                @endswitch
            </div>
        </div>
        @if ($preenchendo)
            </form>
        @endif
</x-layouts.main>
