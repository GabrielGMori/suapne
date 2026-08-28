@props(['count'])

@php
    use App\Enums\RoleEnum;

    $plural = $count === 1 ? '' : 's';
    $isProfessorRegular = Auth::user()->role === RoleEnum::PROFESSOR_REGULAR;
    $notificationType = $isProfessorRegular ? ('pendente' . $plural) : 'aguardando revisão';
    $status = $isProfessorRegular ? 'PENDENTE' : 'AGUARDANDO_REVISAO';
@endphp

<x-layouts.main title="Planos de Trabalho do Estudante">
    <div class="flex flex-col gap-3 mt-10">
        @if($count > 0)
            <x-icon icon="notification_important" size="45"
                label="Existe{{$count === 1 ? '' : 'm'}} {{$count}} PTE{{$plural}} {{ $notificationType }}" />
            <x-button color="tertiary" label="Ver Planos" type="link"
                :href="url()->current().'?'.http_build_query(['filter' => ['status' => [$status]]])" />
        @else
            <x-icon icon="check" class="text-primary-accent" size="45"
                label="Não há PTEs {{ $notificationType }} no momento" />
        @endif
    </div>
    <hr class="my-10 text-on-surface">
    <livewire:list-view :config="App\Tables\PlanoTrabalhoEstudanteTable::class" />
</x-layouts.main>
