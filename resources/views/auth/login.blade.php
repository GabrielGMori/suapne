<x-layouts.auth title="Teste" cardTitle="Olá, mundo!">
    <x-auth-card title="Login" titleMargin="10" width="125">

        <div class="flex flex-col gap-1 mb-3">
            <x-form-input type="text" label="Nome:" />
            <x-form-input type="password_forgot" label="Senha:" />
        </div>

        <x-button text="Acessar" type="submit" size="full" />
        <div class="flex flex-col w-full">
            <p class="text-body-small text-white">Não possui uma conta?</p>
            <x-button text="Solicitar cadastro" type="link" href="#" size="full" />
        </div>
    </x-auth-card>
</x-layouts.auth>
