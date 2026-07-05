<?php

use App\Models\Curso;
use App\Enums\EtniaEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\SexoEnum;

?>

<x-layouts.main title="Cadastro de estudante">
    <form action="{{ route('estudantes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados do estudante</h2>
            <hr class="mb-5 text-on-surface">
            <div class="grid grid-cols-3">

                <livewire:avatar-upload />

                <div class="flex flex-wrap gap-5 w-full col-span-2 items-center">
                    <livewire:form.input label="Nome completo*" appearance="outlined" size="large" name="nome" required/>
                    <livewire:form.input label="Matrícula*" appearance="outlined" size="large" name="matricula" required/>

                    <livewire:form.input type="email" label="E-mail Acadêmico*" appearance="outlined" size="large"
                                         name="email_academico" required/>
                    <livewire:form.input type="email" label="E-mail Pessoal" appearance="outlined" size="large"
                                         name="email_pessoal"/>

                    <livewire:form.input type="date" label="Data de nascimento*" appearance="outlined" size="large"
                                         name="data_nascimento" required/>
                    <livewire:form.input label="CPF*" appearance="outlined" size="large" name="cpf"
                                         placeholder="000.000.000-00" mask="999.999.999-99" required/>

                    <livewire:form.select label="Curso*" appearance="outlined" size="large" name="curso_id"
                                          :options="Curso::pluck('nome', 'id')->toArray()" required/>
                    <livewire:form.input type="number" label="Período atual do curso*" appearance="outlined" size="large"
                                         name="periodo" placeholder="1º" mask="9" required/>

                    <livewire:form.input type="number" label="Ano de ingresso*" appearance="outlined" size="large"
                                         name="ingresso_ano" placeholder="AAAA" mask="9999" required/>
                    <livewire:form.input type="number" label="Período de ingresso*" appearance="outlined" size="large"
                                         name="ingresso_periodo" placeholder="1º" mask="9" required/>

                    <livewire:form.input label="Nacionalidade" appearance="outlined" size="large" name="nacionalidade"/>
                    <livewire:form.select label="Etnia" placeholder="Selecionar" appearance="outlined" size="large"
                                          name="etnia" :options="EtniaEnum::options()" clearable/>

                    <livewire:form.input label="Naturalidade" appearance="outlined" size="large" name="naturalidade"/>
                    <livewire:form.select label="Sexo*" placeholder="Selecionar" appearance="outlined" size="large"
                                          name="sexo" :options="SexoEnum::options()" required/>

                    <livewire:form.input type="tel" label="Telefone do estudante" appearance="outlined" size="large"
                                         name="telefone" placeholder="+55 (00) 00000-0000"/>
                    <livewire:form.select label="Situação*" appearance="outlined" size="large" name="situacao"
                                          :value="SituacaoEstudanteEnum::MATRICULADO->value" :options="SituacaoEstudanteEnum::options()" required/>

                    <livewire:form.input label="Nome do pai" appearance="outlined" size="large" name="nome_pai"/>
                    <livewire:form.input type="tel" label="Telefone do pai" appearance="outlined" size="large"
                                         name="telefone_pai" placeholder="+55 (00) 00000-0000"/>

                    <livewire:form.input label="Nome da mãe" appearance="outlined" size="large" name="nome_mae"/>
                    <livewire:form.input type="tel" label="Telefone da mãe" appearance="outlined" size="large"
                                         name="telefone_mae" placeholder="+55 (00) 00000-0000"/>

                    <livewire:form.input label="Nome do responsável" appearance="outlined" size="large" name="nome_responsavel"/>
                    <livewire:form.input type="tel" label="Telefone do responsável" appearance="outlined" size="large"
                                         name="telefone_responsavel" placeholder="+55 (00) 00000-0000"/>

                    <livewire:form.input type="email" label="E-mail do responsável" appearance="outlined" size="large"
                                         name="email_responsavel"/>
                </div>
                <div class="col-start-2 col-span-2 mt-5">
                    <livewire:form.input type="textarea" label="Necessidades*" appearance="outlined" name="necessidades"
                                         size="full" required/>
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
