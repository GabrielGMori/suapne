@props(['tipo' => null])

@php
    use App\Enums\TipoDocumentoEnum;
    $resolvedTipo = $tipo !== null ? TipoDocumentoEnum::from($tipo) : TipoDocumentoEnum::DOCUMENTO;
@endphp

<x-layouts.main title="Adicionar {{ $resolvedTipo->label() ?? 'documento' }}">

    <form
        action="{{ route('estudantes.documentos.store', ['estudante' => $estudante, 'tipoDocumento' => $resolvedTipo]) }}"
        method="POST">
        @csrf

        {{-- The Livewire component sits inside the form --}}
        <livewire:document-upload />

        <div class="flex justify-end gap-2 mt-10">
            <x-button label="Cancelar" type="link"
                href="{{ url()->previous() !== url()->current() ? url()->previous() : route('estudantes.show', ['estudante' => $estudante]) }}"
                color="red" />

            <x-button label="Adicionar" type="submit" />
        </div>
    </form>

</x-layouts.main>