@props(['planoFlexibilizacao' => null, 'estudanteId' => null])

<x-layouts.main title="{{ $planoFlexibilizacao == null ? 'Cadastrar plano de flexibilização' : 'Editar plano de flexibilização'}}">
    <livewire:stateful-forms.plano-flexibilizacao :plano-flexibilizacao="$planoFlexibilizacao" :estudante-id="$estudanteId" />
</x-layouts.main>
