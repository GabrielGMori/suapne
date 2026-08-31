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

    <table class="table">
        <tr><td><b>2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular</b><br>(Registrar todas as ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular)</td></tr>
        <tr><td class="textarea">{{ $planoFlexibilizacao->campos['acoesPedagogicas'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td><b>3. Atendimento multiprofissional</b><br>Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante</td></tr>
        <tr><td class="textarea">{{ $planoFlexibilizacao->campos['atendimentoMultiprofissional'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td colspan="2"><b>4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais possibilidades</b></td></tr>
        <tr><td><b>Ações a serem implementadas:</b></td><td><b>Sim ou Não</b></td></tr>
        <tr><td>I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE:</td><td>{{ $planoFlexibilizacao->campos['diferenciacaoCurricular'] ?? '---' }}</td></tr>
        <tr><td>II - Atendimento educacional individualizado realizado pelo professor do componente curricular:</td><td>{{ $planoFlexibilizacao->campos['atendimentoIndividualizado'] ?? '---' }}</td></tr>
        <tr><td>III - Dilação ou redução do prazo para a conclusão do curso:</td><td>{{ $planoFlexibilizacao->campos['alteracaoPrazo'] ?? '---' }}</td></tr>
        <tr><td>IV - Reorganização e/ou equivalência de componente curricular:</td><td>{{ $planoFlexibilizacao->campos['reorganizacaoCurricular'] ?? '---' }}</td></tr>
        <tr><td>V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes:</td><td>{{ $planoFlexibilizacao->campos['criteriosDiferenciados'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td><b>5. Componentes curriculares a serem flexibilizados</b></td></tr>
        <tr><td class="textarea">@foreach ($componentes as $index => $disciplinaId){{ is_numeric($disciplinaId) ? (Disciplina::find($disciplinaId)?->nome ?? $disciplinaId) : $disciplinaId }}{{ $index === $count - 1 ? '.' : ', ' }}@endforeach</td></tr>
    </table>

    <table class="table">
        <tr><td><b>6. Informações adicionais</b></td></tr>
        <tr><td class="textarea">{{ $planoFlexibilizacao->campos['informacoesAdicionais'] ?? '---' }}</td></tr>
    </table>
</x-layouts.pdf>
