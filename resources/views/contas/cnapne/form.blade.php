<x-layouts.main title="Editar conta da CNAPNE">
    <form action="{{ route('contas.cnapne.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados da conta da CNAPNE</h2>
            <hr class="text-on-surface mx-3" />

            <div class="grid grid-cols-3 ml-15">
                <!-- Seção da Foto de Perfil -->
                <div class="grid grid-cols-1 gap-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/img/placeholder-user.png') }}"
                        alt="Foto do Usuário" class="h-50 w-50 object-cover rounded-full shrink-0">

                    <x-button label="Enviar arquivo" color="tertiary" icon="upload_file" iconPos="left" type="button" />
                    <x-button label="Remover imagem" color="red" type="button" />
                </div>


                <div class="gap-4">
                    <livewire:form.input type="text" name="name" label="Nome" appearance="outlined"
                        :value="$user->name" />
                </div>


                <div>
                    <livewire:form.input type="email" name="email" label="E-mail" appearance="outlined"
                        :value="$user->email" />
                </div>
            </div>
        </div>


        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link" href="{{ route('contas.cnapne.index') }}" color="red" />
            <x-button label="Salvar alterações" type="submit" color="primary" />
        </div>
    </form>
</x-layouts.main>
