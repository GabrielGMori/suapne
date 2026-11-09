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

        @if ($atendimento->temCampo('perfilDoEstudante'))
            <tr>
                <td>
                    <b>Perfil do estudante:</b><br>
                    <span class="textarea">{{ $atendimento->campos['perfilDoEstudante'] ?? '---' }}</span>
                </td>
            </tr>
        @endif
    </table>

    <x-campos-adicionais-pdf :registro="$atendimento" />
</x-layouts.pdf>
