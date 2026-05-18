<x-layouts.auth title="Em Breve">
    <x-auth-card title="Em Breve" class="w-125 text-center text-white">
        <p>A função de cadastro não está disponível nesta demonstração.</p>
        <p>No entanto, ainda é possível acessar o sistema sem uma conta clicando em "Acessar" na tela de Login!</p>

        <x-button label="Página inicial" type="link" :href="route('auth.login')" class="mt-3"></x-button>
    </x-auth-card>
</x-layouts.auth>
