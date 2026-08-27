@props(['user'])

<x-layouts.main title="Editar conta da CNAPNE">
    <form action="{{ route('contas.cnapne.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados da conta da CNAPNE</h2>
            <hr class="text-on-surface mx-3" />

            <div class="grid grid-cols-3">
                <livewire:avatar-upload :default-img-path="old('avatar', $user?->avatar)" />
                <x-form.input type="text" name="name" label="Nome" appearance="outlined" :value="$user->name" size="large" />
                <x-form.input type="email" name="email" label="E-mail" appearance="outlined" :value="$user->email" size="large" />

            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link" href="{{ route('contas.cnapne.index') }}" color="red" />
            <x-button label="Salvar alterações" type="submit" color="primary" />
        </div>
    </form>
</x-layouts.main>
