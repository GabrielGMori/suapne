<x-secao-expansivel title="Planos de Flexibilização Curricular" class="mt-5">
    <div class="p-5 flex flex-col gap-2">
        @if (count($estudante->planosFlexibilizacaoCurricular) > 0)
            @foreach ($estudante->planosFlexibilizacaoCurricular as $plano)
                <x-documento name="{{ $plano->nome }}" icon="tune">
                    <p>Criado por: {{ $plano->user->nome }}</p>
                    <p>Data de criação: {{ $plano->created_at->format('d/m/Y') }}</p>
                    <x-button icon="open_in_new" color="transparent" type="link"
                        href="{{ route('planos-flexibilizacao.show', ['planos_flexibilizacao' => $plano]) }}" />
                </x-documento>
            @endforeach
        @else
            <p>Nenhum plano foi criado no momento</p>
            <x-button.add href="{{ route('planos-flexibilizacao.create') }}" />
        @endif
    </div>
    <x-slot:topActions>
        {{-- <x-button icon="search" color="transparent"></x-button> --}}
        <x-button icon="add" color="transparent"></x-button>
    </x-slot:topActions>
</x-secao-expansivel>
