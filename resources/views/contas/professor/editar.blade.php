<x-layouts.main title="Editar conta de professor">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Dados do professor</h2>
        <hr>
            <div class="grid grid-cols-3 ml-15">
                <div class="grid grid-cols-1 gap-4">
                    <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário" class="h-50 w-50 object-cover rounded-full shrink-0">
                    <x-button label="Enviar arquivo" color="tertiary" icon="upload_file" iconPos="left"/>
                    <x-button label="Remover imagem" color="red"/>    
                </div>
                <div class="gap-4"> 
                    <x-form-input type="text" label="Nome" appearance="outlined"/>
                    <x-form-input type="multiselect" label="Disciplinas" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                </div>
                <div>
                    <x-form-input type="email" label="E-mail" appearance="outlined"/>
                </div>
            </div>
        </div>
    <div class="flex justify-end">
        <x-button label="Confirmar edições"/>
    </div>
</x-layouts.main>