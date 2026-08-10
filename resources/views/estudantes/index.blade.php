<x-layouts.main title="Estudantes">
    <livewire:list-view :config="App\Tables\EstudanteTable::class" :filtersExpanded="$filtersExpanded" />
</x-layouts.main>
