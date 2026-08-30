@can('viewAny', App\Models\EntrevistaFamiliar::class)
    <x-secao-expansivel title="Entrevistas" class="mt-5">
        <div class="p-5">
            <p class="text-title-medium mb-2">Estudante</p>
            @if ($estudante->entrevistaEstudante)
                <x-documento name="Entrevista com o estudante ({{ $estudante->entrevistaEstudante->fullArquivo }})" icon="edit_note">
                    <p>Enviada por: {{ $estudante->entrevistaEstudante->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->entrevistaEstudante->created_at->format('d/m/Y') }}</p>
                    @can('delete', $estudante->entrevistaEstudante)
                        <x-modal icon="delete" label="" color="transparent" title="Excluir Documento">
                            <p class="mb-5 text-body-large">Tem certeza que deseja excluir este documento?</p>
                            <div class="flex justify-end gap-3 mb-2">
                                <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                                <form action="{{ route('estudantes.documentos.destroy', ['estudante' => $estudante, 'documento' => $estudante->entrevistaEstudante]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <x-button label="Confirmar" type="submit" color="red" />
                                </form>
                            </div>
                        </x-modal>
                    @endcan
                    <x-button icon="download" color="transparent"
                        @click="window.open('{{ Storage::disk('public')->url($estudante->entrevistaEstudante->path) }}', '_blank')" />
                </x-documento>
            @else
                <x-button.add href="{{ route('estudantes.documentos.create', ['estudante' => $estudante, 'tipoDocumento' => 'entrevista_estudante']) }}" />
            @endif
            <p class="text-title-medium my-2">Familiar</p>
            @if ($estudante->entrevistaFamiliar)
                <x-documento name="Entrevista com familiar" icon="edit_note">
                    <p>Enviada por: {{ $estudante->entrevistaFamiliar->user->nome }}</p>
                    <p>Data de envio: {{ $estudante->entrevistaFamiliar->created_at->format('d/m/Y') }}</p>
                    <x-button icon="open_in_new" color="transparent" type="link"
                        href="{{ route('estudantes.entrevistas-familiares.show', ['estudante' => $estudante, 'entrevistaFamiliar' => $estudante->entrevistaFamiliar]) }}" />
                </x-documento>
            @else
                <x-button.add href="{{ route('estudantes.entrevistas-familiares.create', ['estudante' => $estudante]) }}" />
            @endif
        </div>
    </x-secao-expansivel>
@endcan
