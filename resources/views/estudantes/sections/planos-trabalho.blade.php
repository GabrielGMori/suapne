@can('viewAny', App\Models\PlanoTrabalhoEstudante::class)
    <x-secao-expansivel title="{{ Illuminate\Support\Facades\Auth::user()->role === App\Enums\RoleEnum::PROFESSOR_REGULAR ? 'Meus' : '' }} Planos de Trabalho" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($estudante->planosTrabalho) > 0)
            @php
            $planosPorAno = $estudante->planosTrabalho->groupBy(fn($plano) =>
            $plano->created_at->format('Y'))->sortKeysDesc();
            @endphp
            @foreach ($planosPorAno as $ano => $planos)
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
                        @foreach ($planos as $plano)
                        <x-documento name="{{ $plano->nome }}" icon="assignment">
                            <p>Status: {{ $plano->status->label() }}</p>
                            <p>Criado por: {{ $plano->user->nome }}</p>
                            <p>Data de criação: {{ $plano->created_at->format('d/m/Y') }}</p>
                            <x-button icon="open_in_new" color="transparent" type="link"
                                href="{{ route('planos-trabalho.show', ['planoTrabalho' => $plano]) }}" />
                        </x-documento>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p>Nenhum plano foi criado no momento</p>
            <x-button.add href="{{ route('planos-trabalho.create', ['estudante' => $estudante]) }}" />
            @endif
        </div>
        <x-slot:topActions>
            {{-- <x-button icon="search" color="transparent"></x-button> --}}
            <x-button icon="add" color="transparent" type="link"
                href="{{ route('planos-trabalho.create', ['estudante' => $estudante]) }}" />
        </x-slot:topActions>
    </x-secao-expansivel>
@endcan
