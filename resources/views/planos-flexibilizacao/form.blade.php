@props(['planoFlexibilizacao' => null, 'estudanteId' => null])

<x-layouts.main title="Cadastrar Plano de Flexibilização Curricular">
    <livewire:stateful-forms.plano-flexibilizacao :plano-flexibilizacao="$planoFlexibilizacao" :estudante-id="$estudanteId" />
</x-layouts.main>
