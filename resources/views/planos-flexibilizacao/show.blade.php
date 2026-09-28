<?php
use App\Models\Disciplina;

    $componentes = $planoFlexibilizacao->campos['componentesCurriculares'] ?? [];
    $count = count($componentes);
?>

<x-layouts.main title="{{ $planoFlexibilizacao->nome }}">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-title-large">Período de realização: {{ $planoFlexibilizacao->periodo_inicio->format('d/m/Y') }} a
            {{ $planoFlexibilizacao->periodo_fim->format('d/m/Y') }}</h2>
        <x-button label="Exportar como PDF" icon="file_export" color="tertiary" type="link" target="_blank" :href="route('planos-flexibilizacao.exportPdf', [
            'planoFlexibilizacao' => $planoFlexibilizacao,
        ])" />
    </div>
    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small mb-5">1. Dados do estudante</h2>
        <p>Nome: {{ $planoFlexibilizacao->estudante->nome }}</p>
        <p>Curso/Turma: {{ $planoFlexibilizacao->estudante->curso->nome }}</p>
        <p>Série/Ano: {{ $planoFlexibilizacao->estudante->periodo }}</p>
        <p class="mb-5">Laudo: {{ $planoFlexibilizacao->estudante->laudo !== null ? 'Sim' : 'Não' }}</p>
        <p>Necessidade educacional específica:</p>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 mt-5">
            <p class="whitespace-pre-line">{{ $planoFlexibilizacao->estudante->necessidades }}</p>
        </div>
    </div>
    <x-campos-adicionais-exibicao :registro="$planoFlexibilizacao" :ordem-max="4" />

    @if ($planoFlexibilizacao->temCampo('componentesCurriculares'))
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">{{ $planoFlexibilizacao->campoAdicional('componentesCurriculares')['rotulo'] }}</h2>
            <p class="text-body-large">
                @forelse($componentes as $index => $disciplinaId)
                    {{ (is_numeric($disciplinaId) ? (Disciplina::find($disciplinaId)?->nome ?? $disciplinaId) : $disciplinaId) . ($index === $count-1 ? '.' : ',') }}
                @empty
                    ---
                @endforelse
            </p>
        </div>
    @endif

    <x-campos-adicionais-exibicao :registro="$planoFlexibilizacao" :ordem-min="5" />

    <div class="flex justify-end gap-2">
        <x-button label="Voltar" type="link"
            href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-flexibilizacao.index') }}"
            color="tertiary" />

        @can('update', $planoFlexibilizacao)
            <x-button label="Editar" type="link" href="{{ route('planos-flexibilizacao.edit', $planoFlexibilizacao) }}"
            color="yellow" />
        @endcan

        @can('delete', $planoFlexibilizacao)
            <x-modal icon="delete" label="Excluir" color="red" title="Excluir Plano de Flexibilização">

                <p class="mb-5 text-body-large">
                    Tem certeza que deseja excluir este plano de flexibilização?<br>
                    Você poderá restaurá-lo posteriormente.
                </p>
                <div class="flex justify-end gap-3 mb-2">
                    <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                    <form action="{{ route('planos-flexibilizacao.destroy', ['planoFlexibilizacao' => $planoFlexibilizacao]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <x-button label="Confirmar" type="submit" color="red" />
                    </form>
                </div>
            </x-modal>
        @endcan
    </div>
</x-layouts.main>
