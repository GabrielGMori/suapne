<x-layouts.main title="Cursos">
    <div class="flex flex-col gap-5">
       <h2 class="text-display-medium">Filtro</h2>
       <livewire:form.input label="Nome do curso" appearance="outlined"/>
       <x-button label="Pesquisar" color="secondary" icon="search"/>
       <div>
        <livewire:list-view config="App\Tables\CursoTable"/>
       </div>
    </div>
</x-layouts.main>
