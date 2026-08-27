@props(['planoFlexibilizacao' => null, 'estudante' => null])

<x-layouts.main title="Cadastrar Plano de Flexibilização Curricular">
    <livewire:stateful-forms.plano-flexibilizacao :plano-flexibilizacao="$planoFlexibilizacao" :estudante="$estudante" />
</x-layouts.main>
