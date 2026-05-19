<x-layouts.main title="Planos de Trabalho do estudante">
    <div class="flex flex-col gap-2 mt-10">
        <x-icon icon="notification_important" size="60" label="Existem 4 PTEs aguardando revisão" />
        <x-button type="link" href="#" color="tertiary">Ver PTEs </x-button>

    </div>
    <hr class="my-10 text-on-surface">
    <livewire:list-view :config="App\Tables\PlanoTrabalhoEstudanteTable::class" />






</x-layouts.main>