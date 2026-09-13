@props(['user'])

@can('viewAny', App\Models\AtendimentoSemanal::class)
    <x-secao-expansivel title="Atendimentos Registrados por Mim" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($user->atendimentosSemanais) > 0)
                @php
                    $atendimentosPorAno = $user->atendimentosSemanais
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
                                @foreach ($atendimentos->sortByDesc('data') as $atendimento)
                                    <x-documento name="{{ $atendimento->nome }}" icon="article_person">
                                        <p>Local: {{ $atendimento->local }}</p>
                                        <p>Data de realização: {{ $atendimento->data->format('d/m/Y') }}</p>
                                        <x-button icon="open_in_new" color="transparent" type="link"
                                            href="{{ route('atendimentos.show', ['atendimento' => $atendimento]) }}" />
                                    </x-documento>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Nenhum atendimento foi registrado por você no momento</p>
            @endif
        </div>
    </x-secao-expansivel>
@endcan
