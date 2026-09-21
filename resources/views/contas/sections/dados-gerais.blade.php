@props(['user'])

@php
    use App\Enums\RoleEnum;

    $rotaEdicao = $user->role === RoleEnum::PROFESSOR_REGULAR
        ? route('contas.professor.edit', ['user' => $user])
        : route('contas.cnapne.edit', ['user' => $user]);

    $displays = [
        [
            'Nome:' => $user->nome,
            'E-mail:' => $user->email,
            'Função:' => $user->role->label(),
            'Conta criada em:' => $user->created_at->format('d/m/Y'),
        ],
        [
            'Última atualização da conta:' => $user->updated_at->format('d/m/Y'),
            'Disciplinas vinculadas:' => count($user->disciplinas),
            ($isProfessorRegular ? 'Planos de trabalho atribuídos:' : 'Planos de trabalho criados:') => count($planosTrabalho),
            'Planos de flexibilização criados:' => count($user->planosFlexibilizacaoCurricular),
            'Atendimentos registrados:' => count($user->atendimentosSemanais),
        ],
    ];
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
                <x-display-dado label="{{ $label }}" value="{{ $value }}" />
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
