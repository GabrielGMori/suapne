<x-layouts.main title="Cadastro de estudante">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Dados do estudante</h2>
        <hr class="mb-5 text-on-surface">
        <div class="grid grid-cols-3">
            <div class="flex flex-col gap-5 place-items-center">
                <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário"
                class="h-50 w-50 object-cover rounded-full shrink-0">
                <x-button label="Enviar arquivo" color="tertiary" icon="upload_file"/>
                <x-button label="Remover imagem" color="red" />
            </div>
            <div class="flex flex-col gap-5">
                <livewire:form.input label="Nome completo" appearance="outlined" disabled />
                <livewire:form.input type="tel" label="CPF" appearance="outlined" disabled />
                <livewire:form.input type="email" label="E-mail Acadêmico" appearance="outlined" disabled />
                <livewire:form.input type="select" label="Naturalidade" appearance="outlined" disabled />
                <livewire:form.input label="Data de nascimento" appearance="outlined" disabled />
                <livewire:form.input label="Ingresso" appearance="outlined" disabled />
                <livewire:form.input label="Curso" appearance="outlined" disabled />

            </div>
            <div class="flex flex-col gap-5">
                <livewire:form.input label="Matrícula" appearance="outlined" disabled />
                <livewire:form.input type="tel" label="Telefone" appearance="outlined" disabled />
                <livewire:form.input type="email" label="E-mail Pessoal" appearance="outlined" disabled />
                <livewire:form.input label="Nacionalidade" appearance="outlined" disabled />
                <livewire:form.input label="Etnia" appearance="outlined" disabled />
                <livewire:form.input label="Período" appearance="outlined" disabled />
                <livewire:form.input label="Situação" appearance="outlined" disabled />
            </div>
            <div class="col-start-2 col-span-2">
                <livewire:form.input type="textarea" label="Necessidades" appearance="outlined" disabled size="full"/>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('estudantes.index') }}" color="red"/>
        <x-button label="Registrar (Em breve)" disabled/>
    </div>
</x-layouts.main>

