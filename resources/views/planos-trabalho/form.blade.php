@props(['planoTrabalho' => null, 'estudanteId' => ''])

<x-layouts.main title="Criar Plano de Trabalho do Estudante">
    <livewire:stateful-forms.plano-trabalho :plano-trabalho="$planoTrabalho" :estudante-id="$estudanteId" />
</x-layouts.main>
