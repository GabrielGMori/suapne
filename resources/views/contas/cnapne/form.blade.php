@props(['user'])

@php
    use App\Enums\RoleEnum;

    $isAuthUser = $user->id === Auth::user()->id;
@endphp

<x-layouts.main title="Editar conta da CNAPNE">
    <form action="{{ route('contas.cnapne.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados da conta da CNAPNE</h2>
            <hr class="text-on-surface mb-10" />

            <div class="grid grid-cols-3">
                <livewire:avatar-upload :default-img-path="old('avatar', $user?->avatar)" class="row-span-3" />
                <x-form.input name="nome" label="Nome" appearance="outlined" :value="$user->name"
                    size="large" />
                <x-form.input type="email" name="email" label="E-mail" appearance="outlined" :value="$user->email"
                    size="large" />

                <div>
                    <livewire:form.select name="role" label="Função" appearance="outlined" :options="[
                        RoleEnum::TECNICO->value => RoleEnum::TECNICO->label(),
                        RoleEnum::DOCENTE_ESPECIAL->value => RoleEnum::DOCENTE_ESPECIAL->label()
                    ]" :value="$user->role->value" :disabled="$isAuthUser" />

                    @if($isAuthUser)
                        <p class="text-body-small">Não é possível mudar a função da conta sendo utilizada no momento</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="contas.cnapne.index" />
            <x-button label="Salvar alterações" type="submit" color="primary" />
        </div>
    </form>
</x-layouts.main>
