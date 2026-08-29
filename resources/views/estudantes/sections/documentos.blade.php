<x-secao-expansivel title="Documentos" class="mt-5">
    <div class="p-5">
        <p class="text-title-medium mb-2">Laudo</p>
        @if ($estudante->laudo)
            <x-documento name="Laudo ({{ $estudante->laudo->fullArquivo }})">
                <p>Enviada por: {{ $estudante->laudo->user->nome }}</p>
                <p>Data de envio: {{ $estudante->laudo->created_at->format('d/m/Y') }}</p>
                <x-button icon="download" color="transparent"
                    @click="window.open('{{ Storage::disk('public')->url($estudante->laudo->path) }}', '_blank')" />
            </x-documento>
        @else
            <x-button.add
                href="{{ route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'laudo']) }}" />
        @endif
        <p class="text-title-medium my-2">Estudo de Caso</p>
        @if ($estudante->estudoDeCaso)
            <x-documento name="Estudo de Caso ({{ $estudante->estudoDeCaso->fullArquivo }})">
                <p>Enviada por: {{ $estudante->estudoDeCaso->user->nome }}</p>
                <p>Data de envio: {{ $estudante->estudoDeCaso->created_at->format('d/m/Y') }}</p>
                <x-button icon="download" color="transparent"
                    @click="window.open('{{ Storage::disk('public')->url($estudante->estudoDeCaso->path) }}', '_blank')" />
            </x-documento>
        @else
            <x-button.add
                href="{{ route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'estudo_de_caso']) }}" />
        @endif
        <p class="text-title-medium my-2">Ficha CPAE</p>
        @if ($estudante->fichaCpae)
            <x-documento name="Ficha CPAE ({{ $estudante->fichaCpae->fullArquivo }})">
                <p>Enviada por: {{ $estudante->fichaCpae->user->nome }}</p>
                <p>Data de envio: {{ $estudante->fichaCpae->created_at->format('d/m/Y') }}</p>
                <x-button icon="download" color="transparent"
                    @click="window.open('{{ Storage::disk('public')->url($estudante->fichaCpae->path) }}', '_blank')" />
            </x-documento>
        @else
            <x-button.add
                href="{{ route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'ficha_cpae']) }}" />
        @endif
        <p class="text-title-medium my-2">Outros</p>
        <div class="flex flex-col gap-2">
            @foreach ($estudante->outrosDocumentos as $documento)
                <x-documento name="{{ $documento->fullArquivo }}">
                    <p>Enviada por: {{ $documento->user->nome }}</p>
                    <p>Data de envio: {{ $documento->created_at->format('d/m/Y m:i') }}</p>
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($documento->path) }}', '_blank')" />
                </x-documento>
            @endforeach
            <x-button.add href="{{ route('estudantes.documentos.create', ['estudante' => $estudante]) }}" />
        </div>
    </div>
</x-secao-expansivel>
