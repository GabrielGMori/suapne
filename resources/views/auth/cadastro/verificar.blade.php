<x-layouts.auth title="Verificar E-mail">
    <x-auth-card title="Verificar E-mail" class="w-125 text-center text-white">
        <p>Um código foi enviado para o seu e-mail.</p>
        <p>Digite-o abaixo para prosseguir:</p>

        <form action="{{ route('cadastro.verify') }}" method="POST">
            @csrf
            <x-form.verify-code name="code" class="mb-15" />

            <div class="flex flex-col w-full mt-5 gap-4">
                <x-button label="Verificar" type="submit" size="full"></x-button>
                <x-button label="Cancelar" type="link" href="{{ route('cadastro.index') }}" size="full" color="secondary"></x-button>
            </div>
        </form>
    </x-auth-card>
</x-layouts.auth>
