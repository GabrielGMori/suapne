@props(['role'])

<x-layouts.auth title="Solicitar Cadastro - Professor">
    <x-auth-card title="{{ App\Enums\RoleEnum::from($role)->label() }}" class="w-150 text-white">
        <form action="{{ route('cadastro.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <x-form.input name="nome" label="Nome:" size="large" />
            <x-form.input name="email" label="E-mail:" type="email" size="large" />
            <x-form.input name="password" label="Senha:" type="password" size="large" />
            <x-form.input name="password_confirmation" label="Confirmar senha:" type="password" size="large" />

            <div class="flex flex-col w-full mt-5 gap-2">
                <x-button label="Enviar solicitação de cadastro" type="submit" size="full"></x-button>
                <x-button label="Voltar" type="link" href="{{ route('cadastro.index') }}" size="full" color="secondary"></x-button>
            </div>
        </form>
    </x-auth-card>
</x-layouts.auth>
