<?php
    use App\Models\Disciplina;
?>

<x-layouts.main title="{{ $planoFlexibilizacao->nome}}">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-title-large">Período de realização: {{ $planoFlexibilizacao->periodo_inicio->format('d/m/Y') }} a {{ $planoFlexibilizacao->periodo_fim->format('d/m/Y') }}</h2>
        <x-button label="Exportar como PDF" icon="file_export" color="tertiary"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small mb-5">1. Dados do estudante</h2>
        <p>Nome: {{ $planoFlexibilizacao->estudante->nome }}</p>
        <p>Curso/Turma: {{ $planoFlexibilizacao->estudante->curso->nome }}</p>
        <p>Série/Ano: {{ $planoFlexibilizacao->estudante->periodo }}</p>
        <p class="mb-5">Laudo: {{ $planoFlexibilizacao->estudante->laudo !== null ? 'Sim' : 'Não' }}</p>
        <p>Necessidade educacional específica:</p>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 mt-5">
            <p>{{$planoFlexibilizacao->estudante->necessidades}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular</h2>
        <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular)</h3>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>{{$planoFlexibilizacao->campos['acoesPedagogicas']}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
        <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante</h3>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>{{$planoFlexibilizacao->campos['atendimentoMultiprofissional']}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais possibilidades</h2>
        <p class="text-body-large">I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE: {{$planoFlexibilizacao->campos['diferenciacaoCurricular']}}</p>
        <p class="text-body-large">II - Atendimento educacional individualizado realizado pelo professor do componente curricular: {{$planoFlexibilizacao->campos['atendimentoIndividualizado']}}</p>
        <p class="text-body-large">III - Dilação ou redução do prazo para a conclusão do curso: {{$planoFlexibilizacao->campos['alteracaoPrazo']}}</p>
        <p class="text-body-large">IV  - Reorganização e/ou equivalência de componente curricular: {{$planoFlexibilizacao->campos['reorganizacaoCurricular']}}</p>
        <p class="text-body-large">V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes: {{$planoFlexibilizacao->campos['criteriosDiferenciados']}}</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
        <p class="text-body-large">
            @foreach($planoFlexibilizacao->campos['componentesCurriculares'] as $disciplinaId)
                {{ Disciplina::find($disciplinaId)->nome}};
            @endforeach
        </p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">6. Informações adicionais</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>{{$planoFlexibilizacao->campos['informacoesAdicionais']}}</p>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel label="Voltar" color="tertiary" fallback="planos-flexibilizacao.index" color="tertiary" />
    </div>
</x-layouts.main>
