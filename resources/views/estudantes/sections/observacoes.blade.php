<x-secao-expansivel title="Observações" class="mt-5">
    <x-slot:topActions>
        <livewire:modal.stateful.observacoes :estudante="$estudante" />
    </x-slot:topActions>

    <hr class="mx-4 text-on-surface">
    <div class="grid transition-[grid-template-rows] duration-300 ease-out mb-2"
        x-bind:class="expanded ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
        @if (count($estudante->observacoes) > 0)
            <div class="flex flex-col gap-5 my-3">
                @foreach ($estudante->observacoes as $observacao)
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col px-5">
                            <div class="flex gap-1.5 items-center mb-0.5">
                                <p class="text-label-large">{{ $observacao->user->nome }}</p>
                                <p class="text-body-small text-secondary-accent">{{ $observacao->user->role->label() }}</p>
                                <p class="text-body-small text-secondary-accent">
                                    {{ $observacao->created_at->format('d/m/Y \à\s H:i') }}
                                </p>
                            </div>
                            <p class="text-body-medium">{{ $observacao->observacao }}</p>
                        </div>
                        <div class="mr-5">
                            <x-modal title="Remover observação" icon="delete" iconSize="1000" color="transparent">
                                <p class="mb-10 text-body-large">Tem certeza que deseja remover esta observação?
                                    <br>Essa ação é irreversível.
                                </p>
                                <form action="{{ route('estudantes.observacoes.destroy', ['estudante' => $estudante, 'observacaoEstudante' => $observacao]) }}"
                                    method="POST" class="flex justify-end gap-3 mt-1 mb-2">
                                    @method('DELETE')
                                    @csrf
                                    <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                                    <x-button label="Confirmar" type="submit" color="red" />
                                </form>
                            </x-modal>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="p-5">Nenhuma observação registrada</p>
        @endif
    </div>
</x-secao-expansivel>
