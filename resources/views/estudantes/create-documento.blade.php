@props(['tipo' => null])

@php
    use App\Enums\TipoDocumentoEnum as TipoDoc;
    $resolvedTipo = $tipo !== null ? TipoDoc::from($tipo) : TipoDoc::DOCUMENTO;

    $maxDoc = 1;
    if ($resolvedTipo === TipoDoc::DOCUMENTO) {
        $maxDoc = null;
    }
@endphp

<x-layouts.main title="Adicionar {{ $resolvedTipo->label() ?? 'documento' }}">

    <form
        action="{{ route('estudantes.documentos.store', ['estudante' => $estudante, 'tipoDocumento' => $resolvedTipo]) }}"
        method="POST">
        @csrf

        <livewire:document-upload :max-documents="$maxDoc" />

        <div class="flex justify-end gap-2 mt-10">
            <x-button.cancel fallback="estudantes.show" :args="['estudante' => $estudante]" />
            <x-button label="Adicionar" type="submit" />
        </div>
    </form>

</x-layouts.main>
