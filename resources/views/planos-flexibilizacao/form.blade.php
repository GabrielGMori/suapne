<x-layouts.main title="Criar Plano de Flexibilização Curricular">
    <div>
        <h2 class="flex items-center gap-5 mb-5 text-display-small">Período de realização: <livewire:form.input type="date" size="small" name="diainicio-outlined" appearance="outlined"/> a <livewire:form.input type="date" size="small" name="diafim-outlined" appearance="outlined"/></h2>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">1. Dados do estudante</h2>
            <livewire:form.select type="select" label="Estudante" name="estudante_outlined" appearance="outlined" placeholder="Selecionar"/>
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular</h2>
            <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas e tentativas de adaptações realizadas até o momento)</h3>
            <livewire:form.input type="textarea" name="adaptacaopedagogica_outlined" appearance="outlined" size="full"/>
        </div>
         <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
            <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante</h3>
            <livewire:form.input type="textarea" name="atendimentomultiprofissional_outlined" appearance="outlined" size="full"/>
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">4. Flexibilização Curricular, visando a impletenção de 1(uma) ou mais possibilidades</h2>
            <livewire:form.select type="select" label="I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE" :options="['Sim','Não']" name="diferenciacao_outlined" appearance="outlined"/>
            <livewire:form.select type="select" label="II - Atendimento educacional individualizado realizado pelo professor do componente curricular" :options="['Sim','Não']" name="atendimentoindividualizado_outlined" appearance="outlined"/>
            <livewire:form.select type="select" label="III - Dilação ou redução do prazo para a conclusão do curso" :options="['Sim','Não']" name="dilaçãoprazo_outlined" appearance="outlined"/>
            <livewire:form.select type="select" label="IV  - Reorganização e/ou equivalência de componente curricular" :options="['Sim','Não']" name="equivalenciacurricular_outlined" appearance="outlined"/>
            <livewire:form.select type="select" label="V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes." :options="['Sim','Não']" name="criteriosdiferenciados_outlined" appearance="outlined"/>
        </div>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
            <livewire:form.select type="select" label="Componentes curriculares" :options="['Matemática', 'Português', 'Artes']" placeholder="Selecionar" appearance="outlined" />
        </div>
         <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">6. Informações adicionais</h2>
            <livewire:form.input type="textarea" name="atendimentomultiprofissional_outlined" appearance="outlined" size="full"/>
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link" href="{{ route('planos-flexibilizacao.index') }}" color="red"/>
            <x-button label="Registrar (Em breve)" disabled/>
        </div>  
    </div>
</x-layouts.main>
