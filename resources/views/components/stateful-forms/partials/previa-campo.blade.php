@php
    $tipo = $campo['tipo'] ?? 'text';
    $nomePreview = 'previa_' . $campo['chave'];
@endphp

<div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
    <h2 class="text-display-small">{{ $campo['grupoTitulo'] ?? $campo['rotulo'] }}</h2>

    @if (!empty($campo['descricao']))
        <h3 class="text-body-large text-secondary-accent">{{ $campo['descricao'] }}</h3>
    @endif

    @if ($tipo === 'select')
        <div class="form-field">
            <label class="form-label form-label-outlined">{{ $campo['rotulo'] }}</label>
            <div class="form-control form-control-outlined form-control-medium flex items-center justify-between gap-3 opacity-60">
                <span>{{ implode(' / ', array_values($campo['opcoes'] ?? [])) }}</span>
                <x-icon size="22">expand_more</x-icon>
            </div>
        </div>
    @elseif ($tipo === 'especial')
        <div class="flex items-center gap-3 rounded-lg border border-on-surface p-5 text-secondary-accent">
            <x-icon size="24">auto_awesome</x-icon>
            <p class="text-body-medium">
                {{ $campo['motivoFixo'] ?? 'Campo com preenchimento próprio do sistema.' }}
            </p>
        </div>
    @else
        <x-form.input :type="$tipo" :name="$nomePreview" appearance="outlined"
            :size="$tipo === 'textarea' ? 'full' : 'medium'" disabled />
    @endif
</div>
