<x-layouts.main title="Atendimento Semanal com Ricardo Borges - 30/03/2026">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-title-large">Data do atendimento: 30/03/2026</h3>
            <h3 class="text-title-large">Feito por: Rosiane Carvalho</h3>
        </div>
        <div class="flex justify-end">
            <x-button label="Exportar como PDF" color="tertiary" icon="file_export"/> 
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
        <p>Nome: Ricardo Borges</p>
        <p>Curso/Turma: Informática 4</p>
        <p>Idade: 17 anos</p>
        <p class="mb-5">Local: CNAPNE-IFPR Campus Curitiba</p>
        <livewire:form.input type="textarea" label="Perfil do Estudante" appearance="surface" name="perfildoestudante-outlined" size="full" disabled value="Perfil do Estudante
...
...
..."/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do atendimento</h2>
        <livewire:form.input type="textarea" appearance="surface" name="perfildoestudante-outlined" size="full" disabled value="Registro do atendimento
...
...
..."/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <livewire:form.input type="textarea" appearance="surface" name="perfildoestudante-outlined" size="full" disabled value="Encaminhamentos referentes ao estudante
...
...
..."/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações</h2>
        <livewire:form.input type="textarea" appearance="surface" name="perfildoestudante-outlined" size="full" disabled value="Observações do atendimento
...
...
..."/>
    </div>
</x-layouts.main>
