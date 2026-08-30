<x-layouts.auth title="Alterar Senha">
    <x-auth-card title="Alterar Senha" titleMargin="1" class="pb-13 max-w-150">
        <form action="{{route('password.forgot.submit')}}" method="POST" class="flex flex-col gap-2">
            @csrf

            <x-form.input label="E-mail:" name="email" placeholder="Digite seu e-mail"/>

            @error('credentials') <p class="text-error text-center">{{$message}}</p> @enderror

            <div class="flex flex-col w-full gap-2">
                <x-button label="Prosseguir" type="submit" size="full"/>
                <x-button label="Voltar" type="link" href="{{ route('login') }}" size="full" color="secondary"></x-button>
            </div>
        </form>
    </x-auth-card>
</x-layouts.auth>
