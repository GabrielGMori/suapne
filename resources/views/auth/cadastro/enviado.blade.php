<x-layouts.auth title="Em Breve">
    <x-auth-card title="Em Breve" class="w-125 text-center text-white">
        <p>A função de cadastro não está disponível nesta demonstração.</p>
        <p>Você pode utilizar as credenciais temporárias a seguir:</p>

        <div class="flex flex-col">
            <p><b>E-mail:</b> admin@exemplo.com</p>
            <p><b>Senha:</b> 123</p>
        </div>

        <x-button label="Página inicial" type="link" :href="route('login')" class="mt-3"></x-button>
    </x-auth-card>
</x-layouts.auth>
