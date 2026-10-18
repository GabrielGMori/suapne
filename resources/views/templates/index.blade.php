@php
    use App\Enums\TipoFormularioEnum;
    use App\Models\TemplateFormulario;

    $contagens = TemplateFormulario::selectRaw('tipo, count(*) as total')->groupBy('tipo')->pluck('total', 'tipo');

    $cartoes = [
        TipoFormularioEnum::PLANO_FLEXIBILIZACAO->value => ['icone' => 'tune', 'resumo' => 'Define o que será flexibilizado no currículo do estudante.'],
        TipoFormularioEnum::PLANO_TRABALHO->value => ['icone' => 'assignment', 'resumo' => 'Preenchido pela CNAPNE e completado pelo docente de cada componente.'],
        TipoFormularioEnum::ATENDIMENTO_SEMANAL->value => ['icone' => 'article_person', 'resumo' => 'Registro de cada encontro semanal com o estudante.'],
    ];
@endphp

<x-layouts.main title="Templates" header="Escolha o formulário">
    <div class="flex flex-wrap justify-center items-stretch gap-8 py-10">
        @foreach (TipoFormularioEnum::cases() as $tipo)
            @php $info = $cartoes[$tipo->value]; @endphp

            @php $total = $contagens[$tipo->value] ?? 0; @endphp

            <a href="{{ route('templates.tipo', ['tipo' => $tipo]) }}"
                class="relative flex w-80 max-w-full cursor-pointer flex-col items-center gap-5 overflow-hidden rounded-2xl bg-surface p-8 pt-10
                       focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-accent">

                <div class="absolute inset-x-0 top-0 h-2 bg-primary"></div>

                <div class="flex h-28 w-28 items-center justify-center rounded-full bg-primary text-white">
                    <x-icon size="60">{{ $info['icone'] }}</x-icon>
                </div>

                <h2 class="text-title-medium text-center text-balance">{{ $tipo->label() }}</h2>

                <p class="text-body-medium text-secondary-accent text-center grow">{{ $info['resumo'] }}</p>

                <x-status :filled="false" :color="$total > 0 ? 'success' : 'dark'"
                    :label="$total . ' ' . ($total === 1 ? 'template' : 'templates')" />

                <span class="flex items-center gap-1 text-label-medium text-primary">
                    Abrir
                    <x-icon size="20">arrow_forward</x-icon>
                </span>
            </a>
        @endforeach
    </div>
</x-layouts.main>
