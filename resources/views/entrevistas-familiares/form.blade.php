@props(['estudante' => null, 'entrevistaFamiliar' => null])

<x-layouts.main title="{{ $entrevistaFamiliar == null ? 'Entrevista Escolar Familiar' : 'Editar Entrevista Escolar Familiar' }}">
    <livewire:stateful-forms.entrevista-familiar :entrevista-familiar="$entrevistaFamiliar" :estudante="$estudante" />
</x-layouts.main>
