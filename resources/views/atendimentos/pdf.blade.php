@props(['atendimento'])

<?php
use App\Models\Disciplina;

?>

<x-layouts.pdf>
    <p class="text-center mb-lg">ATENDIMENTO SEMANAL</p>

    <div class="border text-center mb-md bold">
        Atendimento semanal com o estudante
    </div>


    <p class="mb-md">Data do atendimento: {{$atendimento->data->format('d/m/Y \à\s H:i')}}<br>
        Feito por: {{$atendimento->user->nome}}
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
                <b>Local: </b>{{$atendimento->local}}
            </td>
        </tr>
        <tr>
            <td class = "textarea">
                <b>Perfil do estudante:</b> {{ $atendimento->campos['perfilDoEstudante'] }}
            </td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <td class="bold">2. Registro do atendimento</td>
        </tr>
        <tr>
            <td class = "textarea">{{$atendimento->campos['registroDoAtendimento']}}</td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <td class = "bold">3. Encaminhamentos</td>
        </tr>
        <tr>
            <td class="textarea">{{$atendimento->campos['encaminhamentos']}}</td>
        </tr>    
    </table>
    <table class="table">
        <tr>
            <td class="bold">4. Observações Adicionais</td>
        </tr>
        <tr>
            <td class="textarea">{{$atendimento->campos['observacoesAdicionais']}}</td>
        </tr>    
    </table>    
</x-layouts.pdf>
