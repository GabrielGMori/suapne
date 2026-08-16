@props(['estudante' => null])

<?php

use App\Models\Curso;
use App\Enums\EtniaEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\SexoEnum;

?>

<x-layouts.main title="{{$estudante == null ? 'Cadastrar estudante' : 'Editar estudante'}}">
    <form
        action="{{ $estudante == null ? route('estudantes.store') : route('estudantes.update', ['estudante' => $estudante]) }}"
        method="POST" enctype="multipart/form-data">
        @if($estudante !== null)
            @method('PATCH')
        @endif
        @csrf

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados do estudante</h2>
            <hr class="mb-5 text-on-surface">
            <div class="grid grid-cols-3">

                <div class="relative">
                    <livewire:avatar-upload class="sticky top-10"
                        :default-img-path="old('avatar', $estudante?->avatar)" />
                </div>

                <div class="flex flex-wrap gap-5 w-full col-span-2 items-center">
                    <livewire:form.input label="Nome completo*" appearance="outlined" size="large" name="nome"
                        :value="$estudante?->nome" required />
                    <livewire:form.input label="Matrícula*" appearance="outlined" size="large" name="matricula"
                        :value="$estudante?->matricula" required />

                    <livewire:form.input type="email" label="E-mail Acadêmico*" appearance="outlined" size="large"
                        name="email_academico" :value="$estudante?->email_academico" required />
                    <livewire:form.input type="email" label="E-mail Pessoal" appearance="outlined" size="large"
                        name="email_pessoal" :value="$estudante?->email_pessoal" />

                    <livewire:form.input type="date" label="Data de nascimento*" appearance="outlined" size="large"
                        name="data_nascimento" :value="$estudante?->data_nascimento->format('Y-m-d')" required />
                    <livewire:form.input label="CPF*" appearance="outlined" size="large" name="cpf"
                        :value="$estudante?->cpf" placeholder="000.000.000-00" mask="999.999.999-99" required />

                    <livewire:form.select label="Curso*" appearance="outlined" size="large" name="curso_id"
                        :value="$estudante?->curso_id" :options="Curso::pluck('nome', 'id')->toArray()" required />
                    <livewire:form.input type="number" label="Período atual do curso*" appearance="outlined"
                        size="large" name="periodo" :value="$estudante?->periodo" placeholder="1º" mask="9" required />

                    <livewire:form.input type="number" label="Ano de ingresso*" appearance="outlined" size="large"
                        name="ingresso_ano" :value="$estudante?->ingresso_ano" placeholder="AAAA" mask="9999"
                        required />
                    <livewire:form.input type="number" label="Período de ingresso*" appearance="outlined" size="large"
                        name="ingresso_periodo" :value="$estudante?->ingresso_periodo" placeholder="1º" mask="9"
                        required />

                    <livewire:form.input label="Nacionalidade" appearance="outlined" size="large" name="nacionalidade"
                        :value="$estudante?->nacionalidade" />
                    <livewire:form.select label="Etnia" placeholder="Selecionar" appearance="outlined" size="large"
                        name="etnia" :value="$estudante?->etnia?->value" :options="EtniaEnum::options()" clearable />

                    <livewire:form.input label="Naturalidade" appearance="outlined" size="large" name="naturalidade"
                        :value="$estudante?->naturalidade" />
                    <livewire:form.select label="Sexo*" placeholder="Selecionar" appearance="outlined" size="large"
                        name="sexo" :value="$estudante?->sexo->value" :options="SexoEnum::options()" required />

                    <livewire:form.input type="tel" label="Telefone do estudante" appearance="outlined" size="large"
                        name="telefone" :value="$estudante?->telefone" placeholder="+55 (00) 00000-0000" />
                    <livewire:form.select label="Situação*" appearance="outlined" size="large" name="situacao"
                        :value="$estudante?->situacao->value ?? SituacaoEstudanteEnum::MATRICULADO->value"
                        :options="SituacaoEstudanteEnum::options()" required />

                    <livewire:form.input label="Nome do pai" appearance="outlined" size="large" name="nome_pai"
                        :value="$estudante?->nome_pai" />
                    <livewire:form.input type="tel" label="Telefone do pai" appearance="outlined" size="large"
                        name="telefone_pai" :value="$estudante?->telefone_pai" placeholder="+55 (00) 00000-0000" />

                    <livewire:form.input label="Nome da mãe" appearance="outlined" size="large" name="nome_mae"
                        :value="$estudante?->nome_mae" />
                    <livewire:form.input type="tel" label="Telefone da mãe" appearance="outlined" size="large"
                        name="telefone_mae" :value="$estudante?->telefone_mae" placeholder="+55 (00) 00000-0000" />

                    <livewire:form.input label="Nome do responsável" appearance="outlined" size="large"
                        name="nome_responsavel" :value="$estudante?->nome_responsavel" />
                    <livewire:form.input type="tel" label="Telefone do responsável" appearance="outlined" size="large"
                        name="telefone_responsavel" :value="$estudante?->telefone_responsavel"
                        placeholder="+55 (00) 00000-0000" />

                    <livewire:form.input type="email" label="E-mail do responsável" appearance="outlined" size="large"
                        name="email_responsavel" :value="$estudante?->email_responsavel" />
                </div>
                <div class="col-start-2 col-span-2 mt-5">
                    <livewire:form.input type="textarea" label="Necessidades*" appearance="outlined" name="necessidades"
                        size="full" :value="$estudante?->necessidades" required />
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link"
                href="{{ url()->previous() !== url()->current() ? url()->previous() : route('estudantes.index') }}"
                color="red" />
            <x-button label="Registrar" type="submit" />
        </div>
    </form>
</x-layouts.main>
