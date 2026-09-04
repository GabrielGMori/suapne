<x-layouts.auth title="Login">
    <x-auth-card title="Login" titleMargin="1" class="pb-13 max-w-150">
        <form action="{{route('login')}}" method="POST" class="flex flex-col gap-2">
            @csrf

            <div class="flex flex-col gap-2 mb-3">
                <x-form.input label="E-mail:" name="email" placeholder="Digite seu e-mail" />
                <x-form.input type="password_forgot" label="Senha:" name="password" placeholder="Digite sua senha" />
            </div>

            @error('credentials') <p class="text-error text-center">{{$message}}</p> @enderror

            <x-button label="Acessar" type="submit" size="full" />
        </form>

        <div class="flex flex-col w-full">
            <p class="text-body-small text-white">Ou logue com uma de nossas contas de demonstração:</p>
            <x-modal label="Login imediato" size="full" class="mt-1" title="Opções de login imediato" background="primary" textColor="white">
                <div class="flex flex-col gap-2">
                    <form action="{{ route('demo-login') }}" method="POST">
                        @csrf
                        <input type="hidden" value="PROFESSOR_REGULAR" name="role">
                        <x-button type="submit" label="Logar como professor de ensino regular" size="full" />
                    </form>

                    <form action="{{ route('demo-login') }}" method="POST">
                        @csrf
                        <input type="hidden" value="TECNICO" name="role">
                        <x-button type="submit" label="Logar como técnico de educação especial" size="full" />
                    </form>

                    <form action="{{ route('demo-login') }}" method="POST">
                        @csrf
                        <input type="hidden" value="DOCENTE_ESPECIAL" name="role">
                        <x-button type="submit" label="Logar como docente de educação especial" size="full" />
                    </form>
                </div>
            </x-modal>
        </div>
    </x-auth-card>
</x-layouts.auth>
