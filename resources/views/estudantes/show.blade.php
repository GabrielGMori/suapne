@php
    $displays = [
        [
            'Nome:' => $estudante->nome,
            'Matrícula:' => $estudante->matricula,
            'Ingresso:' => $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo,
            'Período:' => $estudante->periodo,
            'Curso:' => $estudante->curso->nome,
            'Quant. de períodos do curso:' => $estudante->curso->quantidade_periodos,
            'E-mail pessoal:' => $estudante->email_pessoal,
            'E-mail acadêmico:' => $estudante->email_academico,
            'Telefone:' => $estudante->telefone,
            'Data de nascimento:' => $estudante->data_nascimento->format('d/m/Y'),
        ],
        [
            'Idade:' => $estudante->idade,
            'Situação acadêmica:' => $estudante->situacao->label(),
            'CPF:' => $estudante->cpf,
            'Nacionalidade:' => $estudante->nacionalidade,
            'Naturalidade:' => $estudante->naturalidade,
            'Etnia:' => $estudante->etnia?->label(),
            'Sexo:' => $estudante->sexo->label(),
            'empty' => '',
            'Nome do pai:' => $estudante->nome_pai,
            'Telefone do pai:' => $estudante->telefone_pai,
            'Nome da mãe:' => $estudante->nome_mae,
            'Telefone da mãe:' => $estudante->telefone_mae,
            'Nome do responsável:' => $estudante->nome_responsavel,
            'Telefone do responsável:' => $estudante->telefone_responsavel,
            'E-mail do responsável:' => $estudante->email_responsavel,
        ],
    ];
@endphp

<x-layouts.main title="{{ Str::headline($estudante->nome) }}">
    @include('estudantes.sections.dados-gerais')

    <div class="w-full flex justify-end my-4" x-data="{ expandAll: true }">
        <x-button type="button" x-on:click="expandAll = !expandAll; $dispatch('toggle-collapse', { expand: expandAll })"
            color="secondary">
            <span class="flex items-center gap-1 cursor-pointer">
                <span x-text="expandAll ? 'Recolher Tudo' : 'Expandir Tudo'">Recolher Tudo</span>
                <span class="material-symbols-outlined"
                    x-text="expandAll ? 'unfold_less' : 'unfold_more'">unfold_less</span>
            </span>
        </x-button>
    </div>

    @include('estudantes.sections.necessidades', ['estudante' => $estudante])
    @include('estudantes.sections.observacoes', ['estudante' => $estudante])
    @include('estudantes.sections.entrevistas', ['estudante' => $estudante])
    @include('estudantes.sections.documentos', ['estudante' => $estudante])
    @include('estudantes.sections.planos-flexibilizacao', ['estudante' => $estudante])
    @include('estudantes.sections.planos-trabalho', ['estudante' => $estudante])
    @include('estudantes.sections.atendimentos-semanais', ['estudante' => $estudante])

    <div class="flex justify-end gap-3 mt-5">
        <x-modal title="Excluir estudante" label="Excluir estudante" icon="delete" color="red">
            <p class="mb-10 text-body-large">Tem certeza que deseja excluir este estudante?<br>Você poderá restaurá-lo
                posteriormente.</p>
            <div class="flex justify-end gap-3 mb-2">
                <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                <form action="{{ route('estudantes.destroy', ['estudante' => $estudante]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <x-button label="Confirmar" type="submit" color="red" />
                </form>
            </div>
        </x-modal>
    </div>
</x-layouts.main>
