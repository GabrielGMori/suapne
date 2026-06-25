<?php

use App\Models\Curso;
use App\Enums\EtniaEnum;
use App\Enums\SituacaoEstudanteEnum;

?>

<x-layouts.main title="Cadastro de estudante">
    <form action="{{ route('estudantes.store') }}" method="POST">
        @csrf

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados do estudante</h2>
            <hr class="mb-5 text-on-surface">
            <div class="grid grid-cols-3">
                <div class="flex flex-col gap-5 place-items-center">
                    <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário"
                         class="h-50 w-50 object-cover rounded-full shrink-0">
                    <x-button label="Enviar arquivo" color="tertiary" icon="upload_file"/>
                    <x-button label="Remover imagem" color="red"/>
                </div>
                <div class="flex flex-wrap gap-5 w-full col-span-2 items-center">
                    <livewire:form.input label="Nome completo*" appearance="outlined" size="large" name="nome"/>
                    <livewire:form.input label="CPF*" appearance="outlined" size="large" name="cpf"
                                         placeholder="XXX-XXX-XXX.XX"/>
                    <livewire:form.input type="email" label="E-mail Acadêmico*" appearance="outlined" size="large"
                                         name="email_academico"/>
                    <livewire:form.input label="Naturalidade" appearance="outlined" size="large" name="naturalidade"/>
                    <livewire:form.input type="date" label="Data de nascimento*" appearance="outlined" size="large"
                                         name="data_nascimento"/>
                    <livewire:form.input type="number" label="Ano de ingresso*" appearance="outlined" size="large"
                                         name="ingresso_ano"/>
                    <livewire:form.select label="Curso*" appearance="outlined" size="large" name="curso_id"
                                          :options="Curso::pluck('nome', 'id')->toArray()"/>
                    <livewire:form.input label="Matrícula*" appearance="outlined" size="large" name="matricula"/>
                    <livewire:form.input type="tel" label="Telefone" appearance="outlined" size="large"
                                         name="telefone"/>
                    <livewire:form.input type="email" label="E-mail Pessoal" appearance="outlined" size="large"
                                         name="email_pessoal"/>
                    <livewire:form.input label="Nacionalidade" appearance="outlined" size="large" name="nacionalidade"/>
                    <livewire:form.select label="Etnia" placeholder="Selecionar" appearance="outlined" size="large"
                                          name="etnia" :options="EtniaEnum::options()" clearable/>
                    <livewire:form.select label="Situação*" appearance="outlined" size="large" name="situacao"
                                          value="Matriculado" :options="SituacaoEstudanteEnum::options()"/>
                    <livewire:form.input type="number" label="Período" appearance="outlined" size="large"
                                         name="periodo"/>
                </div>
                <div class="col-start-2 col-span-2 mt-5">
                    <livewire:form.input type="textarea" label="Necessidades*" appearance="outlined" name="necessidades"
                                         size="full"/>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link"
                      href="{{ url()->previous() !== url()->current() ? url()->previous() : route('estudantes.index') }}"
                      color="red"/>
            <x-button label="Registrar" type="submit"/>
        </div>
    </form>
</x-layouts.main>

