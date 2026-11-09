@php
    $chave = $campo['chave'];
    $nome = "campos[{$chave}]";
    $erro = $errors->first("campos.{$chave}");
    $rotulo = $compacto ? ($campo['rotuloFormulario'] ?? $campo['rotulo']) : null;
    $largo = $campo['tipo'] === 'textarea';
@endphp

@if ($campo['separador'] ?? false)
    <hr class="text-on-surface">
@endif

@if ($campo['tipo'] === 'select')
    <livewire:form.select :label="$rotulo" :name="$nome" appearance="outlined" :options="$campo['opcoes'] ?? []"
        :size="$campo['tamanho'] ?? 'medium'" :placeholder="$secoes ? 'Selecionar' : ''"
        wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" wire:key="select-{{ $chave }}" />
@else
    <x-form.input :type="$campo['tipo']" :label="$rotulo" :name="$nome" appearance="outlined" :size="$campo['tamanho'] ?? ($largo ? 'full' : 'medium')"
        wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" :error="$erro" />
@endif
