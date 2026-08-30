<x-layouts.auth title="Solicitar Cadastro">
    <x-auth-card title="Solicitar Cadastro" class="w-125 text-white">
        <p>Escolha o tipo de cadastro que deseja fazer</p>

        <div class="flex flex-col w-full gap-2">
            <x-button label="Sou um professor de ensino regular" type="link" :href="route('cadastro.professor')" size="full"></x-button>
            <x-button label="Sou um técnico de edução especial" type="link" :href="route('cadastro.tecnico')" size="full"></x-button>
            <x-button label="Sou um docente de educação especial" type="link" :href="route('cadastro.docente')" size="full"></x-button>
        </div>

        <div class="flex flex-col w-full">
            <p class="text-body-small text-white mb-1">Já possui uma conta?</p>
            <x-button label="Fazer login" type="link" :href="route('login')" size="full"></x-button>
        </div>
    </x-auth-card>
</x-layouts.auth>
