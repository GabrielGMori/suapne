@props(['atendimento' => null, 'estudanteId' => null])

<x-layouts.main title="Registrar Atendimento semanal">
    <livewire:stateful-forms.atendimento :atendimento="$atendimento" :estudanteId="$estudanteId" />
</x-layouts.main>
