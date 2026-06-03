<x-layouts.main title="{{ Str::headline($estudante->nome) }}">
    <x-secao-expansivel.bottom title="Dados Gerais">
        <div class="flex gap-20 justify-center items-center px-20">
            <img src="{{ $estudante->avatar }}" class="h-50 rounded-full" alt="{{ $estudante->avatar }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                <x-display-dado label="Nome:" value="{{ $estudante->nome }}" />
                <x-display-dado label="Matrícula:" value="{{ $estudante->matricula }}" />
                <x-display-dado label="Ingresso:"
                    value="{{ $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo }}" />
                <x-display-dado label="Período:" value="{{ $estudante->periodo }}" />
                <x-display-dado label="Curso:" value="{{ $estudante->curso->nome }}" />
                <x-display-dado label="Quant. de períodos do curso:"
                    value="{{ $estudante->curso->quantidade_periodos }}" />
                <x-display-dado label="E-mail pessoal:" value="{{ $estudante->email_pessoal }}" />
                <x-display-dado label="E-mail acadêmico:" value="{{ $estudante->email_academico }}" />
                <x-display-dado label="Telefone:" value="{{ $estudante->telefone }}" />
                <x-display-dado label="Data de nascimento:" value="{{ $estudante->data_nascimento }}" />
            </div>
        </div>

        <x-slot:hidden>
            <div class="flex gap-20 justify-center items-center px-20">
                <div class="min-w-50"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                    <x-display-dado label="Situação acadêmica:" value="{{ $estudante->situacao->label() }}" />
                    <x-display-dado label="CPF:" value="{{ $estudante->cpf }}" />
                    <x-display-dado label="Nacionalidade:" value="{{ $estudante->nacionalidade }}" />
                    <x-display-dado label="Naturalidade:" value="{{ $estudante->naturalidade }}" />
                    <x-display-dado label="Etnia:" value="{{ $estudante->etnia->label() }}" />
                    <x-display-dado label="Sexo:" value="{{ $estudante->sexo->label() }}" />
                    <x-display-dado label="Nome do pai:" value="{{ $estudante->nome_pai }}" />
                    <x-display-dado label="Telefone do pai:" value="{{ $estudante->telefone_pai }}" />
                    <x-display-dado label="Nome da mãe:" value="{{ $estudante->nome_mae }}" />
                    <x-display-dado label="Telefone da mãe:" value="{{ $estudante->telefone_mae }}" />
                    <x-display-dado label="Nome do responsável:" value="{{ $estudante->nome_responsavel }}" />
                    <x-display-dado label="Telefone do responsável:" value="{{ $estudante->telefone_responsavel }}" />
                    <x-display-dado label="E-mail do responsável:" value="{{ $estudante->email_responsavel }}" />
                </div>
            </div>
        </x-slot:hidden>
    </x-secao-expansivel.bottom>

    <div class="w-full flex justify-end my-4" x-data="{ expandAll: true }">
        <x-button
            type="button"
            x-on:click="expandAll = !expandAll; $dispatch('toggle-collapse', { expand: expandAll })"
            color="secondary"
        >
            <span class="flex items-center gap-1 cursor-pointer">
                <span x-text="expandAll ? 'Recolher Tudo' : 'Expandir Tudo'">Recolher Tudo</span>
                <span class="material-symbols-outlined" x-text="expandAll ? 'unfold_less' : 'unfold_more'">unfold_less</span>
            </span>
        </x-button>
    </div>

    <x-secao-expansivel title="Necessidades" class="mt-5">
        <p class="p-5">{{ $estudante->necessidades }}</p>
        <header class="flex justify-between items-center px-5 py-3">
            <p class="text-display-small">Observações</p>
        </header>
        <hr class="mx-4 text-on-surface">

        @if (count($estudante->observacoes) > 0)
            <div class="flex flex-col gap-5 my-3">
                @foreach ($estudante->observacoes as $observacao)
                    <div class="flex flex-col px-5">
                        <div class="flex gap-1.5 items-center mb-0.5">
                            <p class="text-title-small">{{ $observacao->user->nome }}</p>
                            <p class="text-body-small text-secondary-accent">{{ $observacao->user->role->label() }}</p>
                            <p class="text-body-small text-secondary-accent">{{ $observacao->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="text-body-medium">{{ $observacao->observacao }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="p-5">Nenhuma observação registrada</p>
        @endif
    </x-secao-expansivel>

    <x-secao-expansivel title="Entrevistas" class="mt-5">
        <div class="p-5">
            <p class="text-title-medium mb-2">Estudante</p>
            @if ($estudante->entrevistaEstudante)
                <x-documento name="Entrevista com o estudante" actionIcon="download" actionUrl="#" icon="edit_note">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: {{ $estudante->entrevistaEstudante->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
                </x-documento>
            @else
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.documentos.add', ['id' => $estudante->id])}}" />
            @endif
            <p class="text-title-medium my-2">Familiar</p>
            @if ($estudante->entrevistaFamiliar)
                <x-documento name="Entrevista com familiar" actionUrl="{{route('estudantes.entrevistas-familiares.show', ['id' => $estudante->entrevistaFamiliar->id])}}" icon="edit_note">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: {{ $estudante->entrevistaFamiliar->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
                </x-documento>
            @else
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.entrevistas-familiares.form')}}" />
            @endif
        </div>
    </x-secao-expansivel>

    <x-secao-expansivel title="Documentos" class="mt-5">
        <div class="p-5">
            <p class="text-title-medium mb-2">Laudo</p>
            @if ($estudante->laudo)
                <x-documento name="Laudo" actionIcon="download" actionUrl="#">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: {{ $estudante->laudo->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
                </x-documento>
            @else
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.documentos.add', ['id' => $estudante->id])}}" />
            @endif
            <p class="text-title-medium my-2">Estudo de Caso</p>
            @if ($estudante->estudoDeCaso)
                <x-documento name="Estudo de Caso" actionIcon="download" actionUrl="#">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: {{ $estudante->estudoDeCaso->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
                </x-documento>
            @else
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.documentos.add', ['id' => $estudante->id])}}" />
            @endif
            <p class="text-title-medium my-2">Ficha CPAE</p>
            @if ($estudante->fichaCpae)
                <x-documento name="Ficha CPAE" actionIcon="download" actionUrl="#">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: {{ $estudante->fichaCpae->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
                </x-documento>
            @else
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.documentos.add', ['id' => $estudante->id])}}" />
            @endif
            <p class="text-title-medium my-2">Outros</p>
                <div class="flex flex-col gap-2">
                    @foreach ($estudante->outrosDocumentos as $documento)
                        <x-documento name="{{ $documento->nome }}" actionIcon="download" actionUrl="#">
                            <x-slot:metadata>
                                <p>Enviada  por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                                <p>Data de envio: {{ $documento->created_at->format('d/m/Y') }}</p>
                            </x-slot:metadata>
                        </x-documento>
                    @endforeach
                    <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('estudantes.documentos.add', ['id' => $estudante->id])}}" />
                </div>
        </div>
    </x-secao-expansivel>

    <x-secao-expansivel title="Planos de Flexibilização Curricular" class="mt-5">
        <div class="p-5 flex flex-col gap-2">
            @if (count($estudante->planosFlexibilizacaoCurricular) > 0)
                @foreach ($estudante->planosFlexibilizacaoCurricular as $plano)
                    <x-documento name="Plano de Flexibilização Curricular {{ $estudante->nome }} - {{ $plano->ano }}"
                        icon="tune" actionUrl="{{route('planos-flexibilizacao.show',  ['id' => $plano->id])}}">
                        <x-slot:metadata>
                            <p>Criado por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                            <p>Data de criação: {{ $plano->created_at->format('d/m/Y') }}</p>
                        </x-slot:metadata>
                    </x-documento>
                @endforeach
            @else
                <p>Nenhum plano foi criado no momento</p>
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('planos-flexibilizacao.form')}}" />
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
                    <div x-data="{ yearExpanded: true }" x-on:toggle-collapse.window="yearExpanded = $event.detail.expand" class="p-2">
                        <header class="flex justify-between items-center cursor-pointer select-none" x-on:click="yearExpanded = !yearExpanded">
                            <p class="text-title-medium">{{ $ano }}</p>
                            <button type="button" class="flex items-center text-black hover:opacity-70 transition-opacity cursor-pointer">
                                <x-icon icon="keyboard_arrow_down" size="30" class="transition-transform duration-200" x-bind:class="yearExpanded ? 'rotate-180' : ''" />
                            </button>
                        </header>
                        <div class="grid transition-[grid-template-rows] duration-300 ease-out" x-bind:class="yearExpanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                            <div class="min-h-0 overflow-hidden flex flex-col gap-2 pt-3">
                                @foreach ($planos as $plano)
                                    <x-documento name="PTE {{ $estudante->nome }} - {{ $plano->disciplina->nome }} - {{ $plano->created_at->format('Y') }}"
                                        icon="assignment" actionUrl="{{route('planos-trabalho.show', ['id' => $plano->id])}}">
                                        <x-slot:metadata>
                                            <p>Status: {{ $plano->status->label() }}</p>
                                            <p>Criado por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                                            <p>Data de criação: {{ $plano->created_at->format('d/m/Y') }}</p>
                                        </x-slot:metadata>
                                    </x-documento>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum plano foi criado no momento</p>
                <x-button label="Adicionar" icon="add" color="tertiary" type="link" href="{{route('planos-trabalho.form')}}" />
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
                    <x-documento name="Atendimento Semanal com {{ $estudante->nome }} - {{ $atendimento->created_at->format('d/m/Y') }}"
                        icon="article_person" actionUrl="{{route('atendimentos.show',['id'=>$atendimento->id])}}">
                        <x-slot:metadata>
                            <p>Realizado por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                            <p>Data de realização: {{ $atendimento->created_at->format('d/m/Y') }}</p>
                        </x-slot:metadata>
                    </x-documento>
                @endforeach
            @endif
        </div>

        <x-slot:topActions>
            <x-button icon="search" color="transparent"></x-button>
            <x-button icon="add" color="transparent"></x-button>
        </x-slot:topActions>
    </x-secao-expansivel>
</x-layouts.main>
