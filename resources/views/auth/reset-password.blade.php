@props(['token', 'email'])

<x-layouts.auth title="Alterar Senha">
    <x-auth-card title="Alterar Senha" titleMargin="1" class="pb-13 max-w-150">
        <form action="{{route('password.reset.submit')}}" method="POST" class="flex flex-col gap-2">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <x-form.input label="Nova senha:" name="password" type="password" />
            <x-form.input label="Confirmar nova senha:" name="password_confirmation" type="password" />

            <div class="flex flex-col w-full gap-2 mt-5">
                <x-button label="Prosseguir" type="submit" size="full"/>
                <x-button label="Voltar" type="link" href="{{ route('login') }}" size="full" color="secondary"></x-button>
            </div>
        </form>
    </x-auth-card>
</x-layouts.auth>
