<div>
    <div class="flex items-end justify-between mb-10">
        <div class="flex items-center gap-10">
            <livewire:form.input wire:model="nome" name="nome" type="text" label="Nome do documento"
                appearance="outlined" error="{{ $errors->first('nome') }}" />

            <x-form.file wire:model="arquivo" name="arquivo" id="arquivo-{{ $fileIteration }}" label="Arquivo"
                appearance="outlined" error="{{ $errors->first('arquivo') }}" />
        </div>
        <x-button color="secondary" icon="add" wire:click="addDocument" />
    </div>

    <hr class="text-on-surface">

    <div class="flex flex-col gap-10 mt-10">
        <div class="flex flex-col gap-5">
            @if (count($documents) === 0)
                <p>Envie documentos utilizando o botão "+" acima</p>
            @else
                @foreach ($documents as $document)
                    <x-documento :name="$document['nome'] . '.' . $document['extensao']" icon="draft" actionIcon="download"
                        class="grow" wire:key="doc-{{ $document['id'] }}">
                        <x-slot:metadata>
                            <p>Enviada por: {{ $document['uploaded_by'] }}</p>
                            <p>Data de envio: {{ \Carbon\Carbon::parse($document['enviado_em'])->format('d/m/Y H:i') }}</p>
                            <x-button icon="delete" color="transparent" wire:click="removeDocument('{{ $document['id'] }}')" />
                            <x-button icon="download" color="transparent"
                                @click="window.open('{{ Storage::disk('public')->url($document['arquivo']) }}', '_blank')" />
                        </x-slot:metadata>
                    </x-documento>
                @endforeach
            @endif
        </div>
    </div>


    @foreach ($documents as $index => $document)
        <input type="hidden" name="documentos[{{ $index }}][id]" value="{{ $document['id'] }}">
        <input type="hidden" name="documentos[{{ $index }}][nome]" value="{{ $document['nome'] }}">
        <input type="hidden" name="documentos[{{ $index }}][extensao]" value="{{ $document['extensao'] }}">
        <input type="hidden" name="documentos[{{ $index }}][path]" value="{{ $document['arquivo'] }}"> 
    @endforeach
</div>
