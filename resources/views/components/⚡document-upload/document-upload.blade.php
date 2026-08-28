<div>
    <div class="flex items-center justify-between {{ $maxDocuments > 1 ? 'mb-10' : '' }}">
        <div class="flex items-center gap-10">
            <x-form.input wire:model.live.debounce.300ms="nome" name="nome" label="Nome do documento"
                appearance="outlined" error="{{ $errors->first('nome') }}"/>

            <x-form.file wire:model="arquivo" name="arquivo" id="arquivo-{{ $fileIteration }}" label="Arquivo"
                         appearance="outlined" error="{{ $errors->first('arquivo') }}"/>
        </div>
        @if(($maxDocuments ?? 2) > 1 && $arquivo && ($maxDocuments === null || count($documents) < $maxDocuments))
            <x-button color="secondary" icon="add" wire:click="addDocument"/>
        @endif
        @if(($maxDocuments ?? 2) > 1 && count($documents) === $maxDocuments)
            <p>Limite de arquivos atingido</p>
        @endif
    </div>

    @if(($maxDocuments ?? 2) < 2)
        @error('documentos')
            <p class="text-red">Por favor, envie um arquivo</p>
        @enderror
    @else
        <hr class="text-on-surface">
        <div class="my-5">
            <h3>Lista de arquivos</h3>
            @if($maxDocuments)
                <p class="text-body-small">Quantidade máxima de arquivos: {{ $maxDocuments }}</p>
            @endif
        </div>

        @error('documentos')
            <p class="text-red">Por favor, adicione ao menos um arquivo à lista</p>
        @enderror

        <div class="flex flex-col gap-10">
            <div class="flex flex-col gap-5">
                @if ($arquivo && count($documents) === 0 && ($maxDocuments === null || count($documents) < $maxDocuments))
                    <p>Confirme o envio do arquivo utilizando o botão "+" acima</p>
                @elseif (count($documents) === 0)
                    <p>Nenhum arquivo foi enviado no momento</p>
                @else
                    @foreach ($documents as $document)
                        <x-documento :name="$document['nome'] . '.' . $document['extensao']" icon="draft"
                                    actionIcon="download"
                                    class="grow" wire:key="doc-{{ $document['id'] }}">
                            <x-slot:metadata>
                                <p>Enviada por: {{ $document['uploaded_by'] }}</p>
                                <p>Data de
                                    envio: {{ \Carbon\Carbon::parse($document['enviado_em'])->format('d/m/Y \à\s H:i') }}</p>
                                <x-button icon="delete" color="transparent"
                                        wire:click="removeDocument('{{ $document['id'] }}')"/>
                                <x-button icon="download" color="transparent"
                                        @click="window.open('{{ Storage::disk('public')->url($document['arquivo']) }}', '_blank')"/>
                            </x-slot:metadata>
                        </x-documento>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    @foreach ($documents as $index => $document)
        <input type="hidden" name="documentos[{{ $index }}][id]" value="{{ $document['id'] }}">
        <input type="hidden" name="documentos[{{ $index }}][nome]" value="{{ $document['nome'] }}">
        <input type="hidden" name="documentos[{{ $index }}][extensao]" value="{{ $document['extensao'] }}">
        <input type="hidden" name="documentos[{{ $index }}][path]" value="{{ $document['arquivo'] }}">
    @endforeach
</div>
