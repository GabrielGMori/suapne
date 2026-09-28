@php
    $chave = $campo['chave'];
    $nome = "campos[{$chave}]";
    $erro = $errors->first("campos.{$chave}");
    $rotulo = $compacto ? ($campo['rotuloFormulario'] ?? $campo['rotulo']) : null;
    $largo = $campo['tipo'] === 'textarea';
@endphp

@if (!$podeEditar)
    @if ($campo['tipo'] === 'select')
        <livewire:form.select :label="$rotulo" :name="$nome" appearance="outlined" :options="$campo['opcoes'] ?? []"
            wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" wire:key="select-{{ $chave }}" />
    @else
        <x-form.input :type="$campo['tipo']" :label="$rotulo" :name="$nome" appearance="outlined" :size="$largo ? 'full' : 'medium'"
            wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" :error="$erro" />
    @endif
@elseif ($largo)
    <div class="flex flex-col" wire:key="campo-{{ $chave }}">
        <div class="flex justify-between items-center">
            <label for="{{ $nome }}" class="form-label form-label-outlined">{{ $rotulo }}</label>
            <x-botao-remover-campo acao="remover('{{ $chave }}')" :rotulo="$rotulo" />
        </div>
        <x-form.input :type="$campo['tipo']" :name="$nome" appearance="outlined" size="full"
            wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" :error="$erro" />
    </div>
@else
    <div class="flex items-end gap-2" wire:key="campo-{{ $chave }}">
        @if ($campo['tipo'] === 'select')
            <livewire:form.select :label="$rotulo" :name="$nome" appearance="outlined" :options="$campo['opcoes'] ?? []"
                wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" wire:key="select-{{ $chave }}" />
        @else
            <x-form.input :type="$campo['tipo']" :label="$rotulo" :name="$nome" appearance="outlined" size="medium"
                wire:model="valores.{{ $chave }}" :value="$valores[$chave] ?? ''" :error="$erro" />
        @endif

        <x-botao-remover-campo acao="remover('{{ $chave }}')" :rotulo="$rotulo" class="mb-3" />
    </div>
@endif
