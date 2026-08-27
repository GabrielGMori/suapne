<x-layouts.main title="Editar conta de professor">
    <form action="{{ route('contas.professor.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados do professor</h2>
            <hr>

            <div class="grid grid-cols-3 ml-15">

                <div class="grid grid-cols-1 gap-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/img/placeholder-user.png') }}"
                        alt="Usuário" class="h-50 w-50 object-cover rounded-full shrink-0">

                    <x-button label="Enviar arquivo" color="tertiary" icon="upload_file" iconPos="left" type="button" />

                    <x-button label="Remover imagem" color="red" type="button" />
                </div>

                <div class="flex flex-col gap-4">
                    <x-form.input type="text" name="name" label="Nome" appearance="outlined"
                        :value="$user->name" />

                    <x-form.input type="multiselect" label="Disciplinas" appearance="outlined" />
                </div>

                <div>
                    <x-form.input type="email" name="email" label="E-mail" appearance="outlined"
                        :value="$user->email" />
                </div>

            </div>
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link" href="{{ route('contas.professor.index') }}" color="red" />

            <x-button label="Salvar alterações" type="submit" color="primary" />
        </div>
    </form>
</x-layouts.main>
