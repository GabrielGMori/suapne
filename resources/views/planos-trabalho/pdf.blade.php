@props(['planoTrabalho'])

<x-layouts.pdf>
    <p class="text-center mb-lg bold">PLANO DE TRABALHO DO ESTUDANTE</p>

    <div class="border text-center mb-md bold">
        Adaptação e/ou flexibilização curricular
    </div>

    <p class="mb-md">Período de realização: {{ $planoTrabalho->periodo_inicio->format('d/m/Y') }} a  {{ $planoTrabalho->periodo_fim->format('d/m/Y') }}</p>

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

        @foreach (array_chunk($planoTrabalho->camposAdicionaisFiltrados('dadosEstudante', 'criacao'), 2) as $linha)
            <tr>
                @foreach ($linha as $campo)
                    @php
                        $valor = $planoTrabalho->valorCampo($campo['chave']);
                        if ($campo['chave'] === 'local') {
                            $valor = ($planoTrabalho->created_at ? $planoTrabalho->created_at->format('d/m/Y \à\s h:i ') : '') . ($valor ?? '');
                        }
                    @endphp
                    <td>
                        <b>{{ $campo['rotulo'] }}:</b> {{ filled($valor) ? $valor : '---' }}
                    </td>
                @endforeach
                @if (count($linha) === 1)
                    <td></td>
                @endif
            </tr>
        @endforeach

        <tr>
            <td colspan="2" class="no-border-top">
                <b>Necessidades educacionais específicas:</b><br>
                <span class="textarea">{{ $planoTrabalho->estudante->necessidades }}</span>
            </td>
        </tr>
    </table>

    <x-campos-adicionais-pdf :registro="$planoTrabalho" etapa="criacao" />

    <table class="table">
        <tr><td><b>3. Conteúdos do componente curricular que necessitam de adaptação e/ou flexibilização</b></td></tr>
        <tr><td class="textarea">{{ $planoTrabalho->disciplina->ementa }}</td></tr>
    </table>

    <x-campos-adicionais-pdf :registro="$planoTrabalho" etapa="preenchimento" />
    <x-campos-adicionais-pdf :registro="$planoTrabalho" etapa="livre" />
</x-layouts.pdf>
