@php
    $chave = $campo['chave'];
    $nome = "campos[{$chave}]";
    $erro = $errors->first("campos.{$chave}");
    $rotulo = $compacto ? ($campo['rotuloFormulario'] ?? $campo['rotulo']) : null;
    $largo = $campo['tipo'] === 'textarea';
@endphp

@if ($campo['tipo'] === 'select')
    <livewire:form.select :label="$rotulo" :name="$nome" appearance="outlined" :options="$campo['opcoes'] ?? []"
        wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" wire:key="select-{{ $chave }}" />
@else
    <x-form.input :type="$campo['tipo']" :label="$rotulo" :name="$nome" appearance="outlined" :size="$largo ? 'full' : 'medium'"
        wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" :error="$erro" />
@endif
