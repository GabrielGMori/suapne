@props(['estudante'])

@php
    $displays = [
        [
            'Nome completo:' => $estudante->nome,
            'Nome social:' => $estudante->nome_social,
            'CPF:' => App\Support\Formatter::cpf($estudante->cpf),
            'Data de nascimento:' => $estudante->data_nascimento?->format('d/m/Y'),
            'Idade:' => $estudante->idade,
            'Sexo:' => $estudante->sexo?->label(),
            'Etnia:' => $estudante->etnia?->label(),
            'Nacionalidade:' => $estudante->nacionalidade,
            'Naturalidade:' => $estudante->naturalidade,
            'Matrícula:' => $estudante->matricula,
        ],

        [
            'Situação acadêmica:' => $estudante->situacao?->label(),
            'Curso:' => $estudante->curso?->nome,
            'Quant. de períodos do curso:' => $estudante->curso?->quantidade_periodos,
            'Período:' => $estudante->periodo,
            'Ingresso:' => $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo,
            'E-mail acadêmico:' => $estudante->email_academico,
            'E-mail pessoal:' => $estudante->email_pessoal,
            'Telefone:' => App\Support\Formatter::telefone($estudante->telefone),
            'Nome da mãe:' => $estudante->nome_mae,
            'Telefone da mãe:' => App\Support\Formatter::telefone($estudante->telefone_mae),
            'Nome do pai:' => $estudante->nome_pai,
            'Telefone do pai:' => App\Support\Formatter::telefone($estudante->telefone_pai),
            'Nome do responsável:' => $estudante->nome_responsavel,
            'Telefone do responsável:' => App\Support\Formatter::telefone($estudante->telefone_responsavel),
            'E-mail do responsável:' => $estudante->email_responsavel,
        ],
    ];
@endphp

<x-layouts.main title="{{ Str::headline($estudante->nome) }}">
    @include('estudantes.sections.dados-gerais', ['estudante' => $estudante, 'displays' => $displays])

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

    @can('delete', $estudante)
        <div class="flex justify-end gap-3 mt-5">
            <x-modal title="Excluir Estudante" label="Excluir" icon="delete" color="red">
                @php
                    $planosFlexibilizacao = count($estudante->planosFlexibilizacaoCurricular);
                    $planosTrabalho = count($estudante->planosTrabalho);
                    $atendimentos = count($estudante->atendimentosSemanais);
                    $documentos = count($estudante->documentos->where('tipo', '!=', App\Enums\TipoDocumentoEnum::ENTREVISTA_ESTUDANTE->value));
                    $entrevistas = ($estudante->entrevistaEstudante ? 1 : 0) + ($estudante->entrevistaFamiliar ? 1 : 0);
                    $observacoes = count($estudante->observacoes);
                @endphp

                <p class="mb-5 text-body-large">
                    Tem certeza que deseja excluir este estudante?<br>
                    Isso também removerá tudo relacionado ao estudante:
                </p>

                <ul class="mb-5 list-disc list-inside text-body-large">
                    <li>{{ $planosFlexibilizacao }} plano{{ $planosFlexibilizacao != 1 ? 's' : '' }} de flexibilização
                        curricular</li>
                    <li>{{ $planosTrabalho }} plano{{ $planosTrabalho != 1 ? 's' : '' }} de trabalho</li>
                    <li>{{ $atendimentos }} atendimento{{ $atendimentos != 1 ? 's' : '' }}
                        semana{{ $atendimentos != 1 ? 'is' : 'l' }}</li>
                    <li>{{ $entrevistas }} entrevista{{ $entrevistas != 1 ? 's' : '' }}</li>
                    <li>{{ $documentos }} documento{{ $documentos != 1 ? 's' : '' }}</li>
                    <li>{{ $observacoes }} observaç{{ $observacoes != 1 ? 'ões' : 'ão' }}</li>
                </ul>

                <p class="text-body-large mb-5">
                    Você poderá restaurá-lo junto com os itens acima posteriormente.
                </p>
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
    @endcan
</x-layouts.main>