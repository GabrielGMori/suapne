<x-modal title="Adicionar observação" icon="add" color="transparent" size="2xl">
    <form wire:submit="save">
        <livewire:form.input type="textarea" name="observacao" label="Nova observação" appearance="outlined"
            size="full" wire:model="observacao" />

        <div class="flex justify-end gap-3 mt-1 mb-2">
            <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
            <x-button label="Adicionar" type="submit" color="primary" />
        </div>
    </form>
</x-modal>
