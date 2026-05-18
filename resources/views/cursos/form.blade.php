<x-layouts.main title="Cadastrar curso">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Informações do curso</h2>
        <hr>
        <livewire:form.input label="Nome do curso" appearance="outlined" size="large"/>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ route('cursos.index') }}" color="red"/>
        <x-button label="Registrar (Em breve)" disabled/>
    </div>
</x-layouts.main>
