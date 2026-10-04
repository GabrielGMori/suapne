@props(['planoFlexibilizacao'])

@php
    use App\Models\Disciplina;

    $componentes = $planoFlexibilizacao->campos['componentesCurriculares'] ?? [];
    $count = count($componentes);
@endphp

<x-layouts.pdf>
    <p class="text-center mb-md bold">PLANO DE FLEXIBILIZAÇÃO CURRICULAR</p>

    <p class="mb-md">Período de realização: {{ $planoFlexibilizacao->periodo_inicio->format('d/m/Y') }} a {{ $planoFlexibilizacao->periodo_fim->format('d/m/Y') }}</p>

    <table class="table">
        <tr><td colspan="2" class="bold">1. Dados do estudante</td></tr>
        <tr><td colspan="2"><b>Nome:</b> {{ $planoFlexibilizacao->estudante->nome }}</td></tr>
        <tr><td><b>Curso/Turma:</b> {{ $planoFlexibilizacao->estudante->curso->nome }}</td><td><b>Série/Ano:</b> {{ $planoFlexibilizacao->estudante->periodo }}</td></tr>
        <tr><td colspan="2"><b>Laudo:</b> {{ $planoFlexibilizacao->estudante->laudo !== null ? 'Sim' : 'Não' }}</td></tr>
        <tr><td colspan="2" class="no-border-top"><b>Necessidades educacionais específicas:</b><br><span class="textarea">{{ $planoFlexibilizacao->estudante->necessidades }}</span></td></tr>
    </table>

    <x-campos-adicionais-pdf :registro="$planoFlexibilizacao" ate="componentesCurriculares" />

    @if ($planoFlexibilizacao->temCampo('componentesCurriculares'))
        <table class="table">
            <tr><td><b>{{ $planoFlexibilizacao->campoAdicional('componentesCurriculares')['rotulo'] }}</b></td></tr>
            <tr><td class="textarea">@forelse ($componentes as $index => $disciplinaId){{ is_numeric($disciplinaId) ? (Disciplina::find($disciplinaId)?->nome ?? $disciplinaId) : $disciplinaId }}{{ $index === $count - 1 ? '.' : ', ' }}@empty---@endforelse</td></tr>
        </table>
    @endif

    <x-campos-adicionais-pdf :registro="$planoFlexibilizacao" depois="componentesCurriculares" />
</x-layouts.pdf>
