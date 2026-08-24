@php
    $displays = [
        [
            'Nome:' => $estudante->nome,
            'Matrícula:' => $estudante->matricula,
            'Ingresso:' => $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo,
            'Período:' => $estudante->periodo,
            'Curso:' => $estudante->curso->nome,
            'Quant. de períodos do curso:' => $estudante->curso->quantidade_periodos,
            'E-mail pessoal:' => $estudante->email_pessoal,
            'E-mail acadêmico:' => $estudante->email_academico,
            'Telefone:' => $estudante->telefone,
            'Data de nascimento:' => $estudante->data_nascimento->format('d/m/Y'),
        ],
        [
            'Idade:' => $estudante->idade,
            'Situação acadêmica:' => $estudante->situacao->label(),
            'CPF:' => $estudante->cpf,
            'Nacionalidade:' => $estudante->nacionalidade,
            'Naturalidade:' => $estudante->naturalidade,
            'Etnia:' => $estudante->etnia?->label(),
            'Sexo:' => $estudante->sexo->label(),
            'empty' => '',
            'Nome do pai:' => $estudante->nome_pai,
            'Telefone do pai:' => $estudante->telefone_pai,
            'Nome da mãe:' => $estudante->nome_mae,
            'Telefone da mãe:' => $estudante->telefone_mae,
            'Nome do responsável:' => $estudante->nome_responsavel,
            'Telefone do responsável:' => $estudante->telefone_responsavel,
            'E-mail do responsável:' => $estudante->email_responsavel,
        ],
    ]
@endphp

<x-layouts.main title="{{ Str::headline($estudante->nome) }}">
    <x-secao-expansivel.bottom title="Dados Gerais">
        @can('update', $estudante)
            <x-slot:topActions>
                <x-button type="link" href="{{ route('estudantes.edit', ['estudante' => $estudante]) }}" icon="edit"
                    color="transparent" class="text-white" />
            </x-slot:topActions>
        @endcan

        <div class="flex gap-20 justify-center items-center px-20">
            <img src="{{ asset($estudante->avatar ?? 'storage/img/placeholder-user.png') }}"
                class="h-50 w-50 object-cover rounded-full shrink-0" alt="{{ $estudante->avatar }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                @foreach ($displays[0] as $label => $value)
                    <x-display-dado label="{{ $label }}" value="{{ $value }}" />
                @endforeach
            </div>
        </div>

        <x-slot:hidden>
            <div class="flex gap-20 justify-center items-center px-20">
                <div class="min-w-50"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                    @foreach ($displays[1] as $label => $value)
                        <x-display-dado label="{{ $label }}" value="{{ $value }}" />
                    @endforeach
                </div>
            </div>
        </x-slot:hidden>
    </x-secao-expansivel.bottom>

    <div class="w-full flex justify-end my-4" x-data="{ expandAll: true }">
        <x-button type="button" x-on:click="expandAll = !expandAll; $dispatch('toggle-collapse', { expand: expandAll })"
            color="secondary">
            <span class="flex items-center gap-1 cursor-pointer">
                <span x-text="expandAll ? 'Recolher Tudo' : 'Expandir Tudo'">Recolher Tudo</span>
                <span class="material-symbols-outlined"
                    x-text="expandAll ? 'unfold_less' : 'unfold_more'">unfold_less</span>
            </span>
        </x-button>
    </div>

    <x-secao-expansivel title="Necessidades" class="mt-5">
        <p class="p-5">{{ $estudante->necessidades }}</p>
    </x-secao-expansivel>

    <x-secao-expansivel title="Observações" class="mt-5">
        <x-slot:topActions>
            <livewire:modal.stateful.observacoes :estudante="$estudante" />
        </x-slot:topActions>

        <hr class="mx-4 text-on-surface">
        <div class="grid transition-[grid-template-rows] duration-300 ease-out mb-2"
            x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
            @if (count($estudante->observacoes) > 0)
                <div class="flex flex-col gap-5 my-3">
                    @foreach ($estudante->observacoes as $observacao)
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col px-5">
                                <div class="flex gap-1.5 items-center mb-0.5">
                                    <p class="text-label-large">{{ $observacao->user->nome }}</p>
                                    <p class="text-body-small text-secondary-accent">{{ $observacao->user->role->label() }}</p>
                                    <p class="text-body-small text-secondary-accent">
                                        {{ $observacao->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <p class="text-body-medium">{{ $observacao->observacao }}</p>
                            </div>
                            <div class="mr-5">
                                <x-modal title="Remover observação" icon="delete" iconSize="1000" color="transparent">
                                    <p class="mb-10 text-body-large">Tem certeza que deseja remover esta observação?
                                        <br>Essa ação é irreversível.
                                    </p>
                                    <form
                                        action="{{ route('estudantes.observacoes.destroy', ['estudante' => $estudante, 'observacaoEstudante' => $observacao]) }}"
                                        method="POST" class="flex justify-end gap-3 mt-1 mb-2">
                                        @method('DELETE')
                                        @csrf
                                        <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                                        <x-button label="Confirmar" type="submit" color="red" />
                                    </form>
                                </x-modal>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="p-5">Nenhuma observação registrada</p>
            @endif
        </div>
    </x-secao-expansivel>

    <x-secao-expansivel title="Entrevistas" class="mt-5">
        <div class="p-5">
            <p class="text-title-medium mb-2">Estudante</p>
            @if ($estudante->entrevistaEstudante)
                <x-documento name="Entrevista com o estudante ({{ $estudante->entrevistaEstudante->nomeArquivo }})"
                    icon="edit_note">
                    <p>Enviada por: {{ $estudante->entrevistaEstudante->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->entrevistaEstudante->created_at->format('d/m/Y') }}</p>
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($estudante->entrevistaEstudante->path) }}', '_blank')" />
                </x-documento>
            @else
                <x-button.add
                    href="{{route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'entrevista_estudante'])}}" />
            @endif
            <p class="text-title-medium my-2">Familiar</p>
            @if ($estudante->entrevistaFamiliar)
                <x-documento name="Entrevista com familiar" icon="edit_note">
                    <p>Enviada por: {{ $estudante->entrevistaFamiliar->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->entrevistaFamiliar->created_at->format('d/m/Y') }}</p>
                </x-documento>
            @else
                <x-button.add href="{{route('estudantes.entrevistas-familiares.create', ['estudante' => $estudante])}}" />
            @endif
        </div>
    </x-secao-expansivel>

    <x-secao-expansivel title="Documentos" class="mt-5">
        <div class="p-5">
            <p class="text-title-medium mb-2">Laudo</p>
            @if ($estudante->laudo)
                <x-documento name="Laudo ({{ $estudante->laudo->nomeArquivo }})">
                    <p>Enviada por: {{ $estudante->laudo->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->laudo->created_at->format('d/m/Y') }}</p>
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($estudante->laudo->path) }}', '_blank')" />
                </x-documento>
            @else
                <x-button.add
                    href="{{route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'laudo'])}}" />
            @endif
            <p class="text-title-medium my-2">Estudo de Caso</p>
            @if ($estudante->estudoDeCaso)
                <x-documento name="Estudo de Caso ({{ $estudante->estudoDeCaso->nomeArquivo }})">
                    <p>Enviada por: {{ $estudante->estudoDeCaso->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->estudoDeCaso->created_at->format('d/m/Y') }}</p>
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($estudante->estudoDeCaso->path) }}', '_blank')" />
                </x-documento>
            @else
                <x-button.add
                    href="{{route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'estudo_de_caso'])}}" />
            @endif
            <p class="text-title-medium my-2">Ficha CPAE</p>
            @if ($estudante->fichaCpae)
                <x-documento name="Ficha CPAE ({{ $estudante->fichaCpae->nomeArquivo }})">
                    <p>Enviada por: {{ $estudante->fichaCpae->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->fichaCpae->created_at->format('d/m/Y') }}</p>
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($estudante->fichaCpae->path) }}', '_blank')" />
                </x-documento>
            @else
                <x-button.add
                    href="{{route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'ficha_cpae'])}}" />
            @endif
            <p class="text-title-medium my-2">Outros</p>
            <div class="flex flex-col gap-2">
                @foreach ($estudante->outrosDocumentos as $documento)
                    <x-documento name="{{ $documento->nomeArquivo }}">
                        <p>Enviada por: {{ $documento->user->nome }}</p>
                        <p>Data de envio: {{ $documento->created_at->format('d/m/Y m:i') }}</p>
                        <x-button icon="download" color="transparent"
                            @click="window.open('{{ Storage::disk('public')->url($documento->path) }}', '_blank')" />
                    </x-documento>
                @endforeach
                <x-button.add href="{{route('estudantes.documentos.create', ['estudante' => $estudante])}}" />
            </div>
        </div>
    </x-secao-expansivel>

    <x-secao-expansivel title="Planos de Flexibilização Curricular" class="mt-5">
        <div class="p-5 flex flex-col gap-2">
            @if (count($estudante->planosFlexibilizacaoCurricular) > 0)
                @foreach ($estudante->planosFlexibilizacaoCurricular as $plano)
                    <x-documento name="{{ $plano->nome }}" icon="tune">
                        <p>Criado por: {{ $plano->user->nome }}</p>
                        <p>Data de criação: {{ $plano->created_at->format('d/m/Y') }}</p>
                    </x-documento>
                @endforeach
            @else
                <p>Nenhum plano foi criado no momento</p>
                <x-button.add href="{{route('planos-flexibilizacao.create')}}" />
            @endif
        </div>
        <x-slot:topActions>
            <x-button icon="search" color="transparent"></x-button>
            <x-button icon="add" color="transparent"></x-button>
        </x-slot:topActions>
    </x-secao-expansivel>

    <x-secao-expansivel title="Planos de Trabalho" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($estudante->planosTrabalho) > 0)
                @php
                    $planosPorAno = $estudante->planosTrabalho->groupBy(fn($plano) => $plano->created_at->format('Y'))->sortKeysDesc();
                @endphp
                @foreach ($planosPorAno as $ano => $planos)
                    <div x-data="{ expanded: true }" x-on:toggle-collapse.window="expanded = $event.detail.expand" class="p-2">
                        <header class="flex justify-between items-center cursor-pointer select-none"
                            x-on:click="expanded = !expanded">
                            <p class="text-title-medium">{{ $ano }}</p>
                            <button type="button"
                                class="flex items-center text-black hover:opacity-70 transition-opacity cursor-pointer">
                                <x-icon icon="keyboard_arrow_down" size="30" class="transition-transform duration-200"
                                    x-bind:class="expanded ? 'rotate-180' : ''" />
                            </button>
                        </header>
                        <div class="grid transition-[grid-template-rows] duration-300 ease-out"
                            x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                            <div class="min-h-0 overflow-hidden flex flex-col gap-2 pt-3">
                                @foreach ($planos as $plano)
                                    <x-documento name="{{ $plano->nome }}" icon="assignment">
                                        <p>Status: {{ $plano->status->label() }}</p>
                                        <p>Criado por: {{ $plano->user->nome }}</p>
                                        <p>Data de criaÃ§Ã£o: {{ $plano->created_at->format('d/m/Y') }}</p>
                                    </x-documento>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum plano foi criado no momento</p>
                <x-button.add href="{{route('planos-trabalho.form')}}" />
            @endif
        </div>
        <x-slot:topActions>
            <x-button icon="search" color="transparent"></x-button>
            <x-button icon="add" color="transparent"></x-button>
        </x-slot:topActions>
    </x-secao-expansivel>

    <x-secao-expansivel title="Atendimentos Semanais" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($estudante->atendimentosSemanais) > 0)
                @foreach ($estudante->atendimentosSemanais as $atendimento)
                    <x-documento name="{{ $atendimento->nome }}" icon="article_person">
                        <p>Realizado por: {{ $atendimento->user->nome }}</p>
                        <p>Data de realização: {{ $atendimento->created_at->format('d/m/Y') }}</p>
                    </x-documento>
                @endforeach
            @else
                <p>Nenhum atendimento foi registrado no momento</p>
                <x-button.add href="{{route('atendimentos.create')}}" />
            @endif
        </div>
        <x-slot:topActions>
            <x-button icon="search" color="transparent"></x-button>
            <x-button icon="add" color="transparent"></x-button>
        </x-slot:topActions>
    </x-secao-expansivel>

    <div class="flex justify-end gap-3 mt-5">
        <x-modal title="Excluir estudante" label="Excluir estudante" icon="delete" color="red">
            <p class="mb-10 text-body-large">Tem certeza que deseja excluir este estudante?<br>Você poderá restaurá-lo
                posteriormente.</p>
            <div class="flex justify-end gap-3 mb-2">
                <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                <form action="{{ route('estudantes.destroy', ['estudante' => $estudante]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <x-button label="Confirmar" type="submit" color="red" />
                </form>
            </div>
        </x-modal>
    </div>
</x-layouts.main>
