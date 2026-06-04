<x-layouts.auth title="Login">
    <x-auth-card title="Login" titleMargin="1" class="pb-13 max-w-150">
        <p class="text-white text-center">O login com credenciais ainda não está disponível<br>Apenas clique em 'Acessar'</p>

        <div class="flex flex-col gap-1 mb-3">
            <livewire:form.input label="Nome:" disabled />
            <livewire:form.input type="password_forgot" label="Senha:" disabled />
        </div>

        <x-button label="Acessar" type="link" href="{{ route('dashboard.index') }}" size="full" />
        <div class="flex flex-col w-full">
            <p class="text-body-small text-white">Não possui uma conta?</p>
            <x-button label="Solicitar cadastro" type="link" href="{{ route('auth.cadastro.enviado') }}" size="full" />
        </div>

    </x-auth-card>
</x-layouts.auth>
