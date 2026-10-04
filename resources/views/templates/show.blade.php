@props(['template'])

@php
    use App\Support\CamposTemplate;

    $itens = CamposTemplate::agrupar($template->campos ?? []);
@endphp

<x-layouts.main title="{{ $template->nome }}" header="{{ $template->nome }}">
    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
        <x-button.cancel label="Voltar" color="tertiary" fallback="templates.tipo" :args="['tipo' => $template->tipo]" />

        <div class="flex items-center gap-2">
            @can('update', $template)
                <x-button type="link" icon="edit" label="Editar" color="yellow" size="dynamic"
                    href="{{ route('templates.edit', ['templateFormulario' => $template]) }}" />
            @endcan

            @can('delete', $template)
                <x-modal title="Excluir template" label="Excluir" icon="delete" color="red">
                    <p class="mb-5 text-body-large">
                        Tem certeza que deseja excluir o template <b>{{ $template->nome }}</b>?<br>
                        Formulários já preenchidos não serão alterados.
                    </p>

                    <div class="flex justify-end gap-3 mb-2">
                        <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                        <form action="{{ route('templates.destroy', ['templateFormulario' => $template]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <x-button label="Confirmar" type="submit" color="red" />
                        </form>
                    </div>
                </x-modal>
            @endcan
        </div>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <div class="flex flex-wrap items-center gap-3">
            <h2 class="text-display-small">Dados do template</h2>
            @if ($template->padrao)
                <x-status label="Padrão" color="info" :filled="false" />
            @endif
        </div>
        <hr class="text-on-surface">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
            <x-display-dado label="Formulário:" :value="$template->tipo->label()" />
            <x-display-dado label="Quantidade de campos:" :value="$template->quantidade_campos" />
            <x-display-dado label="Criado por:" :value="$template->user?->nome" />
            <x-display-dado label="Criado em:" :value="$template->created_at->format('d/m/Y')" />
        </div>
    </div>

    <h2 class="text-display-small mb-4">Como o formulário fica</h2>

    @foreach ($itens as $item)
        @if (isset($item['grupo']))
            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">{{ $item['titulo'] }}</h2>

                @foreach ($item['campos'] as $campo)
                    <div class="form-field">
                        <label class="form-label form-label-outlined">{{ $campo['rotulo'] }}</label>
                        <div class="form-control form-control-outlined form-control-medium flex items-center justify-between gap-3 opacity-60">
                            <span>{{ implode(' / ', array_values($campo['opcoes'] ?? [])) }}</span>
                            <x-icon size="22">expand_more</x-icon>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('components.stateful-forms.partials.previa-campo', ['campo' => $item['campo']])
            <div class="mb-5"></div>
        @endif
    @endforeach
</x-layouts.main>
