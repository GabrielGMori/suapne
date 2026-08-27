<x-layouts.auth title="Login">
    <x-auth-card title="Login" titleMargin="1" class="pb-13 max-w-150">
        <form action="{{route('login')}}" method="POST" class="flex flex-col gap-2">
            @csrf

            <div class="flex flex-col gap-2 mb-3">
                <x-form.input label="E-mail:" name="email" placeholder="Digite seu e-mail"/>
                <x-form.input type="password_forgot" label="Senha:" name="password"
                                     placeholder="Digite sua senha"/>
            </div>

            @error('credentials') <p class="text-error text-center">{{$message}}</p> @enderror

            <x-button label="Acessar" type="submit" size="full"/>
        </form>

        <div class="flex flex-col w-full">
            <p class="text-body-small text-white">Não possui uma conta?</p>
            <x-button label="Solicitar cadastro" type="link" href="{{ route('cadastro.enviado') }}" size="full"/>
        </div>
    </x-auth-card>
</x-layouts.auth>
