<x-layouts.auth title="Solicitação Enviada">
    <x-auth-card title="Solicitação Enviada" class="w-125 text-center text-white">
        <p>Sua solicitação de cadastro foi enviada para nosso sistema.</p>
        <p>Uma mensagem será enviada para seu e-mail caso a solicitação for aprovada por um de nossos servidores.</p>

        <x-button label="Página inicial" type="link" :href="route('login')" class="mt-3"></x-button>
    </x-auth-card>
</x-layouts.auth>
