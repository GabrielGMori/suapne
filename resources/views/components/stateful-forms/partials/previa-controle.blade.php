@php
    $tipo = $campo['tipo'] ?? 'text';
    $noBloco = isset($campo['grupo']);
    $rotulo = $campo['rotuloFormulario'] ?? $campo['rotulo'];
@endphp

@if ($tipo === 'select')
    <div class="form-field">
        <label class="form-label form-label-outlined">{{ $rotulo }}</label>
        <div class="form-control form-control-outlined form-control-medium flex items-center justify-between gap-3 opacity-60">
            <span>{{ implode(' / ', array_values($campo['opcoes'] ?? [])) }}</span>
            <x-icon size="22">expand_more</x-icon>
        </div>
    </div>
@elseif ($tipo === 'especial')
    <p class="text-body-medium text-secondary-accent">
        {{ $campo['motivoFixo'] ?? 'Campo com preenchimento automático.' }}
    </p>
@else
    <x-form.input :type="$tipo" :name="'previa_' . $campo['chave']" :label="$noBloco ? $rotulo : null" appearance="outlined"
        :size="$tipo === 'textarea' || $noBloco ? 'full' : 'medium'" disabled />
@endif
