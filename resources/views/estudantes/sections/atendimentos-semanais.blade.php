@props(['estudante'])

@can('viewAny', App\Models\AtendimentoSemanal::class)
    <x-secao-expansivel title="Atendimentos Semanais" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($estudante->atendimentosSemanais) > 0)
                @php
                    $meses = [
                        1 => 'Janeiro',
                        2 => 'Fevereiro',
                        3 => 'Março',
                        4 => 'Abril',
                        5 => 'Maio',
                        6 => 'Junho',
                        7 => 'Julho',
                        8 => 'Agosto',
                        9 => 'Setembro',
                        10 => 'Outubro',
                        11 => 'Novembro',
                        12 => 'Dezembro',
                    ];
                    $atendimentosPorAno = $estudante->atendimentosSemanais
                        ->groupBy(fn($atendimento) => $atendimento->data->year)
                        ->sortKeysDesc();
                @endphp
                @foreach ($atendimentosPorAno as $ano => $atendimentos)
                    <div x-data="{ expanded: {{ (int) $ano === now()->year ? 'true' : 'false' }} }"
                        x-on:toggle-collapse.window="expanded = $event.detail.expand" class="p-2">
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
                                @foreach ($atendimentos->groupBy(fn($atendimento) => $atendimento->data->month)->sortKeysDesc() as $mes => $atendimentosDoMes)
                                    <div x-data="{ expanded: {{ (int) $ano === now()->year && (int) $mes === now()->month ? 'true' : 'false' }} }"
                                        x-on:toggle-collapse.window="expanded = $event.detail.expand">
                                        <header class="flex justify-between items-center cursor-pointer select-none"
                                            x-on:click="expanded = !expanded">
                                            <p class="text-title-small">{{ $meses[$mes] }}</p>
                                            <button type="button"
                                                class="flex items-center text-black hover:opacity-70 transition-opacity cursor-pointer">
                                                <x-icon icon="keyboard_arrow_down" size="26" class="transition-transform duration-200"
                                                    x-bind:class="expanded ? 'rotate-180' : ''" />
                                            </button>
                                        </header>
                                        <div class="grid transition-[grid-template-rows] duration-300 ease-out"
                                            x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                            <div class="min-h-0 overflow-hidden flex flex-col gap-2 pt-2">
                                                @foreach ($atendimentosDoMes as $atendimento)
                                                    <x-documento name="{{ $atendimento->nome }}" icon="article_person">
                                                        <p>Realizado por: {{ $atendimento->user->nome }}</p>
                                                        <p>Data de realização: {{ $atendimento->data->format('d/m/Y') }}</p>
                                                        <x-button icon="open_in_new" color="transparent" type="link"
                                                            href="{{ route('atendimentos.show', ['atendimento' => $atendimento]) }}" />
                                                    </x-documento>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum atendimento foi registrado no momento</p>
                <x-button.add href="{{ route('atendimentos.create', ['estudante' => $estudante]) }}" />
            @endif
        </div>
        <x-slot:topActions>
            {{-- <x-button icon="search" color="transparent"></x-button> --}}
            <x-button icon="add" color="transparent" type="link"
                href="{{ route('atendimentos.create', ['estudante' => $estudante]) }}" />
        </x-slot:topActions>
    </x-secao-expansivel>
@endcan
