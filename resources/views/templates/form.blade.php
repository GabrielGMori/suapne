@props(['tipo', 'template'])

<x-layouts.main title="{{ $template->exists ? 'Editar template' : 'Criar template' }}"
    header="{{ $template->exists ? 'Editar template' : 'Novo template' }} de {{ $tipo->label() }}">

    <livewire:stateful-forms.template-formulario :template="$template" :tipo="$tipo->value"
        wire:key="template-{{ $template->id ?? 'novo' }}" />
</x-layouts.main>
