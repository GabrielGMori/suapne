@props(['planoTrabalho', 'preview' => false, 'previewDisciplinas' => [], 'previewProfessores' => []])

@php
    use App\Enums\RoleEnum;
    use App\Enums\StatusPlanoTrabalhoEnum;

    $isProfessorRegular = Auth::user()->role === RoleEnum::PROFESSOR_REGULAR;
    $preenchendo = !$preview && $isProfessorRegular
                    && ($planoTrabalho->status === StatusPlanoTrabalhoEnum::DEVOLVIDO || $planoTrabalho->status === StatusPlanoTrabalhoEnum::PENDENTE);

    $created_at = $planoTrabalho->created_at ?? now();
    $updated_at = $planoTrabalho->updated_at ?? $created_at;

    $aguardandoDocente = in_array($planoTrabalho->status, [StatusPlanoTrabalhoEnum::PENDENTE, StatusPlanoTrabalhoEnum::DEVOLVIDO], true);
@endphp

<x-layouts.main title="{{ $planoTrabalho->nome }}">
    @if ($preenchendo)
        <form action="{{ route('planos-trabalho.update', ['planoTrabalho' => $planoTrabalho]) }}" method="POST">
            @method('PATCH')
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
                @foreach ($planoTrabalho->camposAdicionaisFiltrados('dadosEstudante', 'criacao') as $campo)
                    @php
                        $valor = $planoTrabalho->valorCampo($campo['chave']);
                        if ($campo['chave'] === 'local') {
                            $valor = $created_at->format('d/m/Y \à\s h:i ') . ($valor ?? '');
                        }
                    @endphp
                    <p>{{ $campo['rotulo'] }}: {{ filled($valor) ? $valor : '---' }}</p>
                @endforeach

                <p class="mt-5">Necessidade educacional específica:</p>
                <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
                    <p class="whitespace-pre-line">{{$planoTrabalho->estudante->necessidades}}</p>
                </div>
            </div>

            <x-campos-adicionais-exibicao :registro="$planoTrabalho" etapa="criacao" />

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">3. Conteúdos do componente curricular que necessitam de adaptação e/ou
                    flexibilização:</h2>
                <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
                    <p class="whitespace-pre-line">{{$planoTrabalho->disciplina->ementa}}</p>
                </div>
            </div>


            @if ($preenchendo)
                <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
                    :estudante-id="$planoTrabalho->estudante_id" :registro="$planoTrabalho" etapa="preenchimento"
                    :mostrar-adicionar="false" wire:key="campos-preenchimento" />

                <livewire:stateful-forms.campos-adicionais :tipo="App\Enums\TipoFormularioEnum::PLANO_TRABALHO->value"
                    :estudante-id="$planoTrabalho->estudante_id" :registro="$planoTrabalho" etapa="livre"
                    wire:key="campos-livres" />
            @else
                @php $vazioDocente = $aguardandoDocente ? 'A ser preenchido pelo docente...' : '---'; @endphp
                <x-campos-adicionais-exibicao :registro="$planoTrabalho" etapa="preenchimento" :vazio="$vazioDocente" :italico-vazio="true" />
                <x-campos-adicionais-exibicao :registro="$planoTrabalho" etapa="livre" :vazio="$vazioDocente" :italico-vazio="true" />
            @endif

            <p>Atualizado pela última vez: {{ $updated_at->format('d/m/Y \à\s H:i') }}</p>

            <div class="flex justify-end gap-2">
                @if($preview)
                    <x-button label="Voltar" color="tertiary" type="button" onclick="window.close()" />
                @else
                    <x-button.cancel label="Voltar" color="tertiary" fallback="planos-trabalho.index" />

                    @switch($planoTrabalho->status)
                        @case(StatusPlanoTrabalhoEnum::PENDENTE)
                            @if(!$isProfessorRegular)
                                @can('update', $planoTrabalho)
                                    <x-button type="link" label="Editar" color="yellow" href="{{ route('planos-trabalho.edit', ['planoTrabalho' => $planoTrabalho]) }}" />
                                @endcan
                            @else
                                <x-button label="Salvar preenchimento" type="submit" size="dynamic" />
                            @endif
                        @break

                        @case(StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)
                            @if (!$isProfessorRegular)
                                <livewire:modal.stateful.revisar-plano-trabalho :plano-trabalho="$planoTrabalho" />
                            @endif
                        @break

                        @case(StatusPlanoTrabalhoEnum::APROVADO)
                            @can('delete', $planoTrabalho)
                                <x-modal title="Excluir Plano de Trabalho do Estudante" label="Excluir" icon="delete" color="red">
                                    <p class="mb-5 text-body-large">
                                        Tem certeza que deseja excluir este PTE?<br>
                                        Você poderá restaurá-lo posteriormente.
                                    </p>

                                    <div class="flex justify-end gap-3 mb-2">
                                        <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                                        <form action="{{ route('planos-trabalho.destroy', ['planoTrabalho' => $planoTrabalho]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <x-button label="Confirmar" type="submit" color="red" />
                                        </form>
                                    </div>
                                </x-modal>
                            @endcan
                        @break

                        @default
                            @if ($preenchendo)
                                <x-button label="Salvar preenchimento" type="submit" size="dynamic" />
                            @endif
                    @endswitch
                @endif
            </div>
        </div>
        @if ($preenchendo)
            </form>
        @endif
</x-layouts.main>
