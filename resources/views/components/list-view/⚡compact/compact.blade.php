<x-secao-expansivel title="{{ $title }}" class="mt-5">
    <div class="p-5 flex flex-col gap-2">
        @if (count($items) > 0)
            @foreach ($items as $item)
                <x-documento name="{{ $item->nome }}" icon="{{  }}"
                    actionUrl="{{route('planos-flexibilizacao.show', ['planos_flexibilizacao' => $item])}}">
                    <x-slot:metadata>
                        <p>Criado por: {{ $item->user->nome }}</p>
                        <p>Data de criação: {{ $item->created_at->format('d/m/Y') }}</p>
                    </x-slot:metadata>
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
