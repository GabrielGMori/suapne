@props(['planoFlexibilizacao' => null, 'estudanteId' => null])

<x-layouts.main title="Criar Plano de Flexibilização Curricular">
    <livewire:stateful-forms.plano-flexibilizacao :plano-flexibilizacao="$planoFlexibilizacao" :estudante-id="$estudanteId" />
</x-layouts.main>
