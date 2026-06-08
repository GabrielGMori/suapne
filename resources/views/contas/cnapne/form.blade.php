<x-layouts.main title="Editar conta da CNAPNE">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small ">Dados da conta da CNAPNE</h2>
        <hr class="text-on-surface mx-3"/>
        <div class="grid grid-cols-3 ml-15">
            <div class="grid grid-cols-1 gap-4">
                <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário" class="h-50 w-50 object-cover rounded-full shrink-0">
                <x-button label="Enviar arquivo" color="tertiary" icon="upload_file" iconPos="left"/>
                <x-button label="Remover imagem" color="red"/>
            </div>
            <div class="gap-4">
                <livewire:form.input type="text" label="Nome" appearance="outlined" disabled/>
            </div>
            <div>
                <livewire:form.input type="email" label="E-mail" appearance="outlined" disabled/>
            </div>
        </div>
        </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('contas.cnapne.index') }}" color="red"/>
        <x-button label="Registrar (Em breve)" disabled/>
    </div>
</x-layouts.main>
