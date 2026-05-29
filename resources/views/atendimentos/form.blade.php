<x-layouts.main title="Registrar Atendimento semanal">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
         <livewire:form.input label="Estudante" name="estudante-outlined" appearance="outlined" placeholder="Selecionar" disabled/>
         <livewire:form.input type="text" label="Local" appearance="outlined" size="small" name="local-outlined" disabled/>
         <livewire:form.input type="datetime" label="Dia" appearance="outlined" name="datetime-outlined" disabled/>
         <livewire:form.input type="textarea" label="Perfil do Estudante" appearance="outlined" name="perfildoestudante-outlined" size="full" disabled/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do Atendimento</h2>
        <livewire:form.input type="textarea" name="registrodoatendimento-outlined" appearance="outlined" size="full" disabled/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <livewire:form.input type="textarea" name="encaminhamentos-outlined" appearance="outlined" size="full" disabled />
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <livewire:form.input type="textarea" name="observacoes-outlined" appearance="outlined" size="full" disabled/>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ route('atendimentos.index') }}" color="red" disabled/>
        <x-button label="Registrar (Em breve)" disabled/>
    </div>
</x-layouts.main>
