<x-layouts.main title="Planos de Flexibilização Curricular">
    <div class="flex flex-col gap-2 mt-10">
        <x-icon icon="notification_important" size="60" label="Existem 4 estudantes sem plano de flexibilização curricular para este ano" />
        <x-button type="link" href="#" color="tertiary">Criar Planos de Flexibilização</x-button>
    </div>
    <hr class="my-10 text-on-surface">
    <livewire:list-view :config="App\Tables\PlanoFlexibilizacaoCurricularTable::class"/>
</x-layouts.main>
