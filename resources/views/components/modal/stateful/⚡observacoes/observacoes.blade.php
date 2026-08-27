<div>
    <x-modal name="modal-observacoes" title="Adicionar observação" icon="add" color="transparent" width="2xl">
        <form wire:submit="save">

            <x-form.input
                type="textarea"
                name="observacao"
                label="Nova observação"
                appearance="outlined"
                size="full"
                wire:model="observacao"
                :error="$errors->first('observacao')"
            />

            <div class="flex justify-end gap-3 mt-4 mb-2">
                <x-button label="Cancelar" color="secondary" type="button" x-on:click="show = false" />
                <x-button label="Adicionar" type="submit" color="primary" />
            </div>
        </form>
    </x-modal>
</div>
