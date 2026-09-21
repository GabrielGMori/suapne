@props(['estudante'])

@php
    $displays = [
        [
            'Nome completo:' => $estudante->nome,
            'Nome social:' => $estudante->nome_social,
            'Matrícula:' => $estudante->matricula,
            'CPF:' => App\Support\Formatter::cpf($estudante->cpf),
            'Curso:' => $estudante->curso?->nome,
            'Período:' => $estudante->periodo,
            'Quant. de períodos do curso:' => $estudante->curso?->quantidade_periodos,
            'Situação acadêmica:' => $estudante->situacao?->label(),
            'Data de nascimento:' => $estudante->data_nascimento?->format('d/m/Y'),
            'Idade:' => $estudante->idade,
        ],

        [
            'Sexo:' => $estudante->sexo?->label(),
            'Etnia:' => $estudante->etnia?->label(),
            'Nacionalidade:' => $estudante->nacionalidade,
            'Naturalidade:' => $estudante->naturalidade,
            'Ingresso:' => $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo,
            'E-mail acadêmico:' => $estudante->email_academico,
            'E-mail pessoal:' => $estudante->email_pessoal,
            'Telefone do estudante:' => App\Support\Formatter::telefone($estudante->telefone),
            'Nome da mãe:' => $estudante->nome_mae,
            'Telefone da mãe:' => App\Support\Formatter::telefone($estudante->telefone_mae),
            'Nome do pai:' => $estudante->nome_pai,
            'Telefone do pai:' => App\Support\Formatter::telefone($estudante->telefone_pai),
            'Nome do responsável:' => $estudante->nome_responsavel,
            'Telefone principal (pai, mãe ou responsável):' => App\Support\Formatter::telefone($estudante->telefone_responsavel),
            'E-mail principal (pai, mãe ou responsável):' => $estudante->email_responsavel,
        ],
    ];
@endphp

<x-secao-expansivel.bottom title="Dados Gerais">
    @can('update', $estudante)
        <x-slot:topActions>
            <x-button type="link" href="{{ route('estudantes.edit', ['estudante' => $estudante]) }}" icon="edit"
                color="transparent" class="text-white" />
        </x-slot:topActions>
    @endcan

    <div class="flex gap-20 justify-center items-center px-20">
        <img src="{{ asset($estudante->avatar ?? 'storage/img/placeholder-user.png') }}"
            class="h-50 w-50 object-cover rounded-full shrink-0" alt="{{ $estudante->avatar }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
            @foreach ($displays[0] as $label => $value)
                <x-display-dado label="{{ $label }}" value="{{ $value }}" />
            @endforeach
        </div>
    </div>

    <x-slot:hidden>
        <div class="flex gap-20 justify-center items-center px-20">
            <div class="min-w-50"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                @foreach ($displays[1] as $label => $value)
                    <x-display-dado label="{{ $label }}" value="{{ $value }}" />
                @endforeach
            </div>
        </div>
    </x-slot:hidden>
</x-secao-expansivel.bottom>
