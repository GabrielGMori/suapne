@php
use App\Models\Disciplina;

$disciplinas = Disciplina::with('curso')->get()->mapWithKeys(fn ($disc) => [$disc->id => "{$disc->nome} -
{$disc->curso->nome}"])->toArray();
@endphp

<x-layouts.auth title="Solicitar Cadastro - Professor">
    <x-auth-card title="Professor de Ensino Regular" class="w-175 text-white">
        <form action="{{ route('cadastro.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="PROFESSOR_REGULAR">

            <div class="flex flex-col gap-2">
                <x-form.input name="nome" label="Nome:" size="xlarge" />
                <x-form.input name="email" label="E-mail:" type="email" size="xlarge" />
                <x-form.input name="password" label="Senha:" type="password" size="xlarge" />
                <x-form.input name="password_confirmation" label="Confirmar senha:" type="password" size="xlarge" />
                <livewire:form.select name="campos[disciplinas]" label="Disciplinas lesionadas:" type="multiselect" size="xlarge"
                    :options="$disciplinas" />
            </div>

            <div class="flex flex-col w-full mt-5 gap-2">
                <x-button label="Enviar solicitação de cadastro" type="submit" size="full"></x-button>
                <x-button label="Voltar" type="link" href="{{ route('login') }}" size="full" color="secondary"></x-button>
            </div>

            @if($errors)
                @foreach ($errors as $error)
                    {{ dump($error) }}
                @endforeach
            @endif
        </form>
    </x-auth-card>
</x-layouts.auth>
