<x-layouts.main title="Cadastrar disciplina">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Informações da disciplina</h2>
        <hr>
            <div class="grid grid-cols-2">
                <div>
                    <livewire:form.input label="Nome do componente curricular" appearance="outlined"/>
                </div>
                <div>
                    <livewire:form.select label="Curso" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                </div>
            </div>
                <div>
                    <livewire:form.input type="textarea" label="Ementa" appearance="outlined" size="full" class="resize-none"/>
                </div>
            </div>
            <div class="flex justify-end">
                <x-button label="Registrar"/>
            </div>
</x-layouts.main>
