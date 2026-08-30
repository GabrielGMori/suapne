@props(['planoTrabalho'])

<x-layouts.pdf>
    <p class="text-center mb-lg bold">PLANO DE TRABALHO DO ESTUDANTE</p>

    <div class="border text-center mb-md bold">
        Adaptação e/ou flexibilização curricular
    </div>

    <p class="mb-md">Período de realização do PTE: {{ $planoTrabalho->periodo_inicio->format('d/m/Y') }} a  {{ $planoTrabalho->periodo_fim->format('d/m/Y') }}</p>

    <table class="table">
        <tr>
            <td colspan="2" class="bold">1. Dados do estudante</td>
        </tr>

        <tr>
            <td>
                <b>Nome:</b> {{ $planoTrabalho->estudante->nome }}
            </td>
            <td></td>
        </tr>

        <tr>
            <td>
                <b>Curso/Turma:</b> {{ $planoTrabalho->estudante->curso->nome }}
            </td>
            <td>
                <b>Série/Ano:</b> {{ $planoTrabalho->estudante->periodo }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Componente curricular:</b> {{ $planoTrabalho->disciplina->nome }}
            </td>
            <td>
                <b>Docente:</b> {{ $planoTrabalho->professor->nome }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Carga horária de atendimento individualizado:</b> {{ $planoTrabalho->campos['cargaHoraria'] ?? '---' }}
            </td>
            <td>
                <b>Dia/Horário/Local:</b> {{ ($planoTrabalho->created_at ? $planoTrabalho->created_at->format('d/m/Y \à\s h:i ') : '') . ($planoTrabalho->campos['local'] ?? '') }}
            </td>
        </tr>

        <tr>
            <td colspan="2" class="no-border-top">
                <b>Necessidades educacionais específicas:</b><br>
                <span class="textarea">{{ $planoTrabalho->estudante->necessidades }}</span>
            </td>
        </tr>
    </table>

    <table class="table">
        <tr><td><b>2. Particularidades do estudante</b></td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->campos['particularidadesEstudante'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td><b>3. Conteúdos do componente curricular que necessitam de adaptação e/ou flexibilização</b></td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->disciplina->ementa }}</td></tr>
    </table>

    <table class="table">
        <tr><td><b>4. Objetivos específicos para o estudante neste período</b></td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->campos['objetivosEspecificos'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td>
            <b>5. Instrumentos avaliativos pretendidos e procedimentos adotados</b><br>
            (De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)
        </td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->campos['instrumentosAvaliativos'] ?? '---' }}</td></tr>
    </table>

    <table class="table">
        <tr><td><b>6. Outras considerações relevantes</b></td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->campos['outrasConsideracoes'] ?? '---' }}</td></tr>
    </table>
</x-layouts.pdf>
