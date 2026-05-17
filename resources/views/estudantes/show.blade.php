<x-layouts.main title="{{ Str::headline($estudante->nome) }}">
    <x-secao-expansivel.bottom title="Dados Gerais">
        <div class="flex gap-20 justify-center items-center px-20">
            <img src="{{ $estudante->avatar }}" class="h-50 rounded-full" alt="{{ $estudante->avatar }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                <x-display-dado label="Nome:" value="{{ $estudante->nome }}" />
                <x-display-dado label="Matrícula:" value="{{ $estudante->matricula }}" />
                <x-display-dado label="Ingresso:"
                    value="{{ $estudante->ingresso_ano . '/' . $estudante->ingresso_periodo }}" />
                <x-display-dado label="Período:" value="{{ $estudante->periodo }}" />
                <x-display-dado label="Curso:" value="{{ $estudante->curso->nome }}" />
                <x-display-dado label="Quant. de períodos do curso:"
                    value="{{ $estudante->curso->quantidade_periodos }}" />
                <x-display-dado label="E-mail pessoal:" value="{{ $estudante->email_pessoal }}" />
                <x-display-dado label="E-mail acadêmico:" value="{{ $estudante->email_academico }}" />
                <x-display-dado label="Telefone:" value="{{ $estudante->telefone }}" />
                <x-display-dado label="Data de nascimento:" value="{{ $estudante->data_nascimento }}" />
            </div>
        </div>

        <x-slot:hidden>
            <div class="flex gap-20 justify-center items-center px-20">
                <div class="min-w-50"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                    <x-display-dado label="Situação acadêmica:" value="{{ $estudante->situacao->label() }}" />
                    <x-display-dado label="CPF:" value="{{ $estudante->cpf }}" />
                    <x-display-dado label="Nacionalidade:" value="{{ $estudante->nacionalidade }}" />
                    <x-display-dado label="Naturalidade:" value="{{ $estudante->naturalidade }}" />
                    <x-display-dado label="Etnia:" value="{{ $estudante->etnia->label() }}" />
                    <x-display-dado label="Sexo:" value="{{ $estudante->sexo->label() }}" />
                    <x-display-dado label="Nome do pai:" value="{{ $estudante->nome_pai }}" />
                    <x-display-dado label="Telefone do pai:" value="{{ $estudante->telefone_pai }}" />
                    <x-display-dado label="Nome da mãe:" value="{{ $estudante->nome_mae }}" />
                    <x-display-dado label="Telefone da mãe:" value="{{ $estudante->telefone_mae }}" />
                    <x-display-dado label="Nome do responsável:" value="{{ $estudante->nome_responsavel }}" />
                    <x-display-dado label="Telefone do responsável:" value="{{ $estudante->telefone_responsavel }}" />
                    <x-display-dado label="E-mail do responsável:" value="{{ $estudante->email_responsavel }}" />
                </div>
            </div>
        </x-slot:hidden>
    </x-secao-expansivel.bottom>

    <x-secao-expansivel title="Necessidades" class="mt-10">
        <p class="p-5">{{ $estudante->necessidades }}</p>
        <header class="flex justify-between items-center px-5 py-3">
            <p class="text-display-small">Observações</p>
        </header>
        <hr class="mx-4 text-on-surface">

        @if (count($estudante->observacoes) > 0)
            <div class="flex flex-col gap-5 my-3">
                @foreach ($estudante->observacoes as $observacao)
                    <div class="flex flex-col px-5">
                        <div class="flex gap-1.5 items-center mb-0.5">
                            <p class="text-title-small">{{ $observacao->user->nome }}</p>
                            <p class="text-body-small text-secondary-accent">{{ $observacao->user->role->label() }}</p>
                            <p class="text-body-small text-secondary-accent">{{ $observacao->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="text-body-medium">{{ $observacao->observacao }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="p-5">Nenhuma observação registrada</p>
        @endif
    </x-secao-expansivel>

    <x-secao-expansivel title="Entrevistas" class="mt-10">
        <div class="p-5">
            <p class="text-title-medium mb-2">Estudante</p>
            <x-documento name="Documento do estudante" date="Data" actionIcon="open_in_new" actionUrl="">
                <x-slot:metadata>
                    <p>Enviada por: Julio</p>
                </x-slot:metadata>
            </x-documento>
            <p class="text-title-medium mb-2">Familiar</p>
        </div>
    </x-secao-expansivel>
</x-layouts.main>
