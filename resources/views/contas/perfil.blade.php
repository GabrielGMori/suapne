@props(['user'])

@php
    use App\Enums\RoleEnum;

    $isProfessorRegular = $user->role === RoleEnum::PROFESSOR_REGULAR;
    $planosTrabalho = $isProfessorRegular ? $user->planosTrabalhoProfessor : $user->planosTrabalhoCriados;
@endphp

<x-layouts.main title="Meu Perfil">
    @include('contas.sections.dados-gerais', ['user' => $user])

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
