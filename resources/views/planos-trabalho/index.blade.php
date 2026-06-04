<x-layouts.main title="Planos de Trabalho do Estudante">
    <div class="flex flex-col gap-3 mt-10">
        @php($planos = \App\Models\PlanoTrabalhoEstudante::where('status', \App\Enums\StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)->count())
        @if($planos > 0)
            <x-icon icon="notification_important" size="45" label="Existem {{$planos}} PTE{{$planos === 1 ? '' : 's'}} aguardando revisão" />
            <x-button color="tertiary" icon="add" label="Ver Planos"/>
        @else
            <x-icon icon="check" class="text-primary-accent" size="45" label="Não há PTEs aguardando revisão no momento" />
        @endif
    </div>
    <hr class="my-10 text-on-surface">
    <livewire:list-view :config="App\Tables\PlanoTrabalhoEstudanteTable::class"/>
</x-layouts.main>
