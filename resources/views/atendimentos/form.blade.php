@props(['atendimento' => null, 'estudante' => null])

<x-layouts.main title="Registrar Atendimento semanal">
    <livewire:stateful-forms.atendimento :atendimento="$atendimento" :estudante="$estudante" />
</x-layouts.main>
