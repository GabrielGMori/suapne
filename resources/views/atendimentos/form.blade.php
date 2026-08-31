@props(['atendimento' => null, 'estudanteId' => null])

<x-layouts.main title="{{ $atendimento == null ? 'Registrar Atendimento semanal' : 'Editar Atendimento semanal' }}">
    <livewire:stateful-forms.atendimento :atendimento="$atendimento" :estudanteId="$estudanteId" />
</x-layouts.main>
