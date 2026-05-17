<x-layouts.main title="Cadastro de estudante">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Dados do estudante</h2>
        <hr class="mb-5">
        <div class="grid grid-cols-3">
            <div class="flex flex-col gap-5 place-items-center">
                <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário"
                class="h-50 w-50 object-cover rounded-full shrink-0">
                <x-button label="Enviar arquivo" color="tertiary" icon="upload_file"/>
                <x-button label="Remover imagem" color="red" />
            </div>
            <div class="flex flex-col gap-5">
                <livewire:form.input type="text" label="Nome completo" appearance="outlined" />
                <livewire:form.input type="tel" label="CPF" appearance="outlined" />
                <livewire:form.input type="email" label="E-mail Acadêmico" appearance="outlined" />
                <livewire:form.input type="text" label="Naturalidade" appearance="outlined" />
                <livewire:form.input type="date" label="Data de nascimento" appearance="outlined" />
                <livewire:form.input type="text" label="Ingresso" appearance="outlined" />
                <livewire:form.input type="text" label="Curso" appearance="outlined" />
                
            </div>
            <div class="flex flex-col gap-5">
                <livewire:form.input type="text" label="Matrícula" appearance="outlined" />
                <livewire:form.input type="tel" label="Telefone" appearance="outlined" />
                <livewire:form.input type="email" label="E-mail Pessoal" appearance="outlined" />
                <livewire:form.input type="text" label="Nacionalidade" appearance="outlined" />           
                <livewire:form.input type="text" label="Etnia" appearance="outlined" />           
                <livewire:form.input type="number" label="Período" appearance="outlined" />
                <livewire:form.input type="text" label="Situação" appearance="outlined" />
            </div>
            <div class="col-start-2 col-span-2">
                <livewire:form.input type="textarea" label="Necessidades" appearance="outlined" size="full"/>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <x-button label="Cadastrar"/>
    </div>
</x-layouts.main>

