@props(['atendimento'])

<x-layouts.pdf>
    <p class="text-center mb-md bold">RELATÓRIO DE ATENDIMENTO SEMANAL</p>

    <p class="mb-md">
        Data do atendimento: {{ $atendimento->data->format('d/m/Y \à\s H:i') }}<br>
        Responsável pelo registro: {{ $atendimento->user->nome }}
    </p>

    <table class="table">
        <tr>
            <td class="bold">1. Dados do estudante</td>
        </tr>

        <tr>
            <td>
                <b>Nome:</b> {{ $atendimento->estudante->nome }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Curso/Turma:</b> {{ $atendimento->estudante->curso->nome }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Idade:</b> {{ $atendimento->estudante->idade }} anos
            </td>
        </tr>

        <tr>
            <td>
                <b>Local:</b> {{ $atendimento->local }}
            </td>
        </tr>

        <tr>
            <td>
                <b>Perfil do estudante:</b><br>
                <span class="textarea">{{ $atendimento->campos['perfilDoEstudante'] }}</span>
            </td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td class="bold">2. Registro do atendimento</td>
        </tr>

        <tr>
            <td class="textarea">{{ $atendimento->campos['registroDoAtendimento'] }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td class="bold">3. Encaminhamentos</td>
        </tr>

        <tr>
            <td class="textarea">{{ $atendimento->campos['encaminhamentos'] }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td class="bold">4. Observações Adicionais</td>
        </tr>

        <tr>
            <td class="textarea">{{ $atendimento->campos['observacoesAdicionais'] }}</td>
        </tr>
    </table>
</x-layouts.pdf>
