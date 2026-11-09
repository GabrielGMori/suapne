@props(['tipo', 'templates', 'ativo'])

<x-layouts.main title="Templates de {{ $tipo->label() }}" header="Templates de {{ $tipo->label() }}">
    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
        <x-button.cancel label="Voltar" color="tertiary" fallback="templates.index" />

        @can('create', App\Models\TemplateFormulario::class)
            <x-button type="link" icon="add" label="Criar template" size="dynamic"
                href="{{ route('templates.create', ['tipo' => $tipo]) }}" />
        @endcan
    </div>

    @if ($templates->isEmpty())
        <div class="flex flex-col items-center gap-5 rounded-xl bg-surface p-12 text-center">
            <x-icon size="60" class="text-secondary-accent">inbox</x-icon>
            <p class="text-body-large">Nenhum template foi criado para este formulário ainda.</p>
            <p class="text-body-medium text-secondary-accent max-w-150">
                Enquanto não houver um template, este formulário usa os campos padrão do sistema.
            </p>
            @can('create', App\Models\TemplateFormulario::class)
                <x-button type="link" icon="add" label="Criar o primeiro template" size="dynamic"
                    href="{{ route('templates.create', ['tipo' => $tipo]) }}" />
            @endcan
        </div>
    @else
        <p class="text-body-medium text-secondary-accent mb-4">
            O template "Em uso" é aplicado em todos os novos formulários. Formulários já preenchidos continuam com o template que usaram.
        </p>

        <div class="flex flex-col gap-4">
            @foreach ($templates as $template)
                <article class="flex flex-wrap items-center gap-4 rounded-xl bg-surface p-5">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-primary text-white">
                        <x-icon size="26">list_alt</x-icon>
                    </div>

                    <div class="grow min-w-60">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('templates.show', ['templateFormulario' => $template]) }}"
                                class="text-title-small hover:text-primary transition-colors">{{ $template->nome }}</a>
                            @if ($template->padrao)
                                <span class="flex items-center text-secondary-accent"
                                    title="Template criado pelo sistema. Não pode ser alterado nem excluído.">
                                    <x-icon size="20">lock</x-icon>
                                </span>
                            @endif
                            @if ($template->is($ativo))
                                <span class="text-body-medium text-secondary-accent">Em uso</span>
                            @endif
                        </div>

                        <p class="text-body-small text-secondary-accent">
                            {{ $template->quantidade_campos }} {{ $template->quantidade_campos === 1 ? 'campo' : 'campos' }}
                            @if ($template->padrao)
                                · criado automático
                            @elseif ($template->user)
                                · criado por {{ $template->user->nome }}
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if (!$template->is($ativo))
                            @can('create', App\Models\TemplateFormulario::class)
                                <form action="{{ route('templates.ativar', ['templateFormulario' => $template]) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <x-button type="submit" icon="check" label="Usar este template" color="secondary"
                                        size="dynamic" title="Usar este template em todos os formulários" />
                                </form>
                            @endcan
                        @endif

                        @can('view', $template)
                            <x-button type="link" icon="visibility" color="transparent" title="Visualizar template"
                                href="{{ route('templates.show', ['templateFormulario' => $template]) }}" />
                        @endcan

                        @can('update', $template)
                            <x-button type="link" icon="edit" color="transparent" title="Editar template"
                                href="{{ route('templates.edit', ['templateFormulario' => $template]) }}" />
                        @endcan

                        @can('delete', $template)
                            <x-modal title="Excluir template" label="" icon="delete" color="transparent">
                                <p class="mb-5 text-body-large">
                                    Tem certeza que deseja excluir o template <b>{{ $template->nome }}</b>?<br>
                                    Formulários já preenchidos não serão alterados.
                                    @if ($template->is($ativo))
                                        <br>Os novos formulários voltarão a usar o template padrão.
                                    @endif
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
                </article>
            @endforeach
        </div>
    @endif
</x-layouts.main>
