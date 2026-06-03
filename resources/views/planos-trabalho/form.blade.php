<x-layouts.main title="Criar Plano de Trabalho do Estudante">

    <div>
        <h2 class="flex items-center gap-5 mb-5 text-display-small">Período de realização:
            <livewire:form.input disabled type="date" size="small" name="diainicio-outlined" appearance="outlined" /> a
            <livewire:form.input disabled type="date" size="small" name="diafim-outlined" appearance="outlined" />
        </h2>
        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <livewire:form.input disabled type="select" label="Estudante" name="estudante_outlined" appearance="outlined"
                placeholder="Selecionar" />
            <livewire:form.input disabled type="select" label="Componentes curriculares" name="estudante_outlined"
                appearance="outlined" placeholder="Selecionar" />
            <livewire:form.input disabled type="select" label="Docentes" name="estudante_outlined" appearance="outlined"
                placeholder="Selecionar" />
            <livewire:form.input disabled type="text" label=" Curso" name="estudante_outlined" appearance="outlined" />
            <livewire:form.input disabled type="datetime" label=" Dia/Hora" name="estudante_outlined" appearance="outlined"
                size="small" />
            <livewire:form.input disabled type="text" label=" Local" name="estudante_outlined" appearance="outlined" />





        </div>

        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Pariculares do estudante </h2>
            <livewire:form.input disabled type="textarea" name="adaptacaopedagogica_outlined" appearance="outlined"
                size="full" />
        </div>


        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small"> 3. Conteúdos do componente curricular que necessitam de adaptação e/ou
                flexibilização: </h2>
            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5 border border-on-surface">
                <p class="text-label-large">
                    Preenchimento automático com base nas disciplinas
                </p>



            </div>

        </div>

         <div class="flex justify-end gap-2">
            <x-button label="Cancelar" color="red" type="link" href="{{ route('planos-trabalho.index') }}" />
            <x-button label="Pré-visualização" color="tertiary" />
            <x-button label="Enviar para docentes (Em breve)" disabled />
        </div>
    </div>
</x-layouts.main>
