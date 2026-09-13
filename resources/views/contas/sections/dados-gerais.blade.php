@props(['user', 'displays'])

@php
    use App\Enums\RoleEnum;

    $rotaEdicao = $user->role === RoleEnum::PROFESSOR_REGULAR
        ? route('contas.professor.edit', ['user' => $user])
        : route('contas.cnapne.edit', ['user' => $user]);
@endphp

<x-secao-expansivel.bottom title="Dados Gerais">
    @can('update', $user)
        <x-slot:topActions>
            <x-button type="link" href="{{ $rotaEdicao }}" icon="edit" color="transparent" class="text-white" />
        </x-slot:topActions>
    @endcan

    <div class="flex gap-20 justify-center items-center px-20">
        <img src="{{ $user->avatar ? asset($user->avatar) : asset('storage/img/placeholder-user.png') }}"
            class="h-50 w-50 object-cover rounded-full shrink-0" alt="Imagem do usuário">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
            @foreach ($displays[0] as $label => $value)
                @if (filled($value))
                    <x-display-dado label="{{ $label }}" value="{{ $value }}" />
                @endif
            @endforeach
        </div>
    </div>

    <x-slot:hidden>
        <div class="flex gap-20 justify-center items-center px-20">
            <div class="min-w-50"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 grow justify-items-stretch">
                @foreach ($displays[1] as $label => $value)
                    <x-display-dado label="{{ $label }}" value="{{ $value }}" />
                @endforeach
            </div>
        </div>
    </x-slot:hidden>
</x-secao-expansivel.bottom>
