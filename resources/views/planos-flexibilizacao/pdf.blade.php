@props(['planoFlexibilizacao'])

<?php
use App\Models\Disciplina;
$count = count($planoFlexibilizacao->campos['componentesCurriculares']);
?>

<x-layouts.pdf>
    <p class="text-center mb-lg">PLANO DE FLEXIBILIZACAO CURRICULAR</p>

    <div class="border text-center mb-md bold">
        Adaptação e/ou flexibilização curricular
    </div>

    <p class="mb-md">Período de realização do Plano de flexibilização:
        {{ $planoFlexibilizacao->periodo_inicio->format('d/m/Y') }} a
        {{ $planoFlexibilizacao->periodo_fim->format('d/m/Y') }}</p>

    <table class="table">
        <tr>
            <td colspan="2" class="bold">1. Dados do estudante</td>
        </tr>
        <tr>
            <td>
                <b>Nome:</b> {{ $planoFlexibilizacao->estudante->nome }}
            </td>
            <td></td>
        </tr>

        <tr>
            <td>
                <b>Curso/Turma:</b> {{ $planoFlexibilizacao->estudante->curso->nome }}
            </td>
            <td>
                <b>Série/Ano:</b> {{ $planoFlexibilizacao->estudante->periodo }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Laudo:</b>
            </td>
            <td>
                {{ $planoFlexibilizacao->estudante->laudo !== null ? 'Sim' : 'Não' }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class = "textarea">
                <b>Necessidade educacional específica:</b> {{ $planoFlexibilizacao->estudante->necessidades }}
            </td>
        </tr>

    </table>

    <table class="table">
        <tr>
            <td><b>2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização
                    curricular</b><br>(Registrar todas as ações pedagógicas já realizadas e justificativa de
                implementação da flexibilização curricular)</td>
        </tr>
        <tr>
            <td class="textarea">{{ $planoFlexibilizacao->campos['acoesPedagogicas'] }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td><b>3. Atendimento multiprofissional</b><br>Profissionais, instituições ou serviços (internos ou externos
                ao IFPR) que fazem o acompanhamento do estudante</td>
        </tr>
        <tr>
            <td class="textarea">{{ $planoFlexibilizacao->campos['atendimentoMultiprofissional'] }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td colspan="2"><b>4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais
                    possibilidades</b></td>
        </tr>
        <tr>
            <td><b>Ações a serem implementadas:</b></td>
            <td><b>Sim ou Não</b></td>
        </tr>
        <tr>
            <td>
                <b>I -Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados
                    no PTE:</b>
            </td>
            <td>{{ $planoFlexibilizacao->campos['diferenciacaoCurricular'] }}</td>
        </tr>

        <tr>
            <td>
                <b>II - Atendimento educacional individualizado realizado pelo professor do componente curricular:</b>
            </td>
            <td>
                {{ $planoFlexibilizacao->campos['atendimentoIndividualizado'] }}
            </td>
        </tr>
        <tr>
            <td>
                <b>III - Dilação ou redução do prazo para a conclusão do curso:</b>
            </td>
            <td>
                {{ $planoFlexibilizacao->campos['alteracaoPrazo'] }}
            </td>
        </tr>
        <tr>
            <td>
                <b>IV - Reorganização e/ou equivalência de componente curricular:</b>
            </td>
            <td>
                 {{ $planoFlexibilizacao->campos['reorganizacaoCurricular'] }}
            </td>   
        </tr>
        <tr>
            <td>
                <b>V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e
                    especificidades dos estudantes:</b>
            </td>
            <td>
                {{ $planoFlexibilizacao->campos['criteriosDiferenciados'] }}
            </td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td>
                <b>5. Componentes curriculares a serem flexibilizados</b><br>
            </td>
        </tr>
        <tr>
            <td class="textarea">
                @foreach ($planoFlexibilizacao->campos['componentesCurriculares'] as $index => $disciplinaId)
                    {{ Disciplina::find($disciplinaId)->nome . ($index === $count - 1 ? '.' : ',') }}
                @endforeach
            </td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td><b>6. Informações adicionais</b></td>
        </tr>
        <tr>
            <td class="textarea">{{ $planoFlexibilizacao->campos['informacoesAdicionais'] ?? '---' }}</td>
        </tr>
    </table>
</x-layouts.pdf>
