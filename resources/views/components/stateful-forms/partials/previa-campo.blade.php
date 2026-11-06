<div class="flex flex-col bg-surface rounded-lg gap-5 p-5">
    <h2 class="text-display-small">{{ App\Support\CamposTemplate::titulo($numero ?? null, $campo['grupoTitulo'] ?? $campo['rotulo']) }}</h2>

    @if (!empty($campo['descricao']))
        <h3 class="text-body-large text-secondary-accent">{{ $campo['descricao'] }}</h3>
    @endif

    @include('components.stateful-forms.partials.previa-controle', ['campo' => $campo])
</div>
