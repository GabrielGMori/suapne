@props(['user'])

@php
    use App\Enums\RoleEnum;

    $isProfessorRegular = $user->role === RoleEnum::PROFESSOR_REGULAR;

    $planosTrabalho = $isProfessorRegular ? $user->planosTrabalhoProfessor : $user->planosTrabalhoCriados;

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

<x-layouts.main title="Meu Perfil">
    @include('contas.sections.dados-gerais', ['user' => $user, 'displays' => $displays])

    <div class="w-full flex justify-end my-4" x-data="{ expandAll: true }">
        <x-button type="button" x-on:click="expandAll = !expandAll; $dispatch('toggle-collapse', { expand: expandAll })"
            color="secondary">
            <span class="flex items-center gap-1 cursor-pointer">
                <span x-text="expandAll ? 'Recolher Tudo' : 'Expandir Tudo'">Recolher Tudo</span>
                <span class="material-symbols-outlined"
                    x-text="expandAll ? 'unfold_less' : 'unfold_more'">unfold_less</span>
            </span>
        </x-button>
    </div>

    @include('contas.sections.disciplinas', ['user' => $user])
    @include('contas.sections.planos-trabalho', ['user' => $user, 'planosTrabalho' => $planosTrabalho])
    @include('contas.sections.planos-flexibilizacao', ['user' => $user])
    @include('contas.sections.atendimentos-semanais', ['user' => $user])
    @include('contas.sections.atividades', ['user' => $user])
</x-layouts.main>
