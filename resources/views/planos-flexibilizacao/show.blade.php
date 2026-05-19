<x-layouts.main title="Plano de Flexibilização Ricardo Borges 2026">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-title-large">Período de realização: 08/02/2026 a 29/11/2026</h2>
        <x-button label="Exportar como PDF" icon="file_export" color="tertiary"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
        <p>Nome: Ricardo Borges</p>
        <p>Curso/Turma: Informática 4</p>
        <p>Série/Ano: 4</p>
        <p class="mb-5">Laudo: sim</p>
        <livewire:form.input type="textarea" label="Necessidade educacional específica" appearance="surface" name="necessidade-educacional-especifica" size="full" disabled value="Necessidade educacional específica"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular</h2>
        <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular)</h3>
        <livewire:form.input type="textarea" appearance="surface" name="historico-acoes-pedagogicas" size="full" disabled value="Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
        <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante</h3>
        <livewire:form.input type="textarea" appearance="surface" name="atendimento-multiprofissional" size="full" disabled value="Atendimento multiprofissional"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Flexibilização Curricular, visando a implementação de 1 (uma) ou mais possibilidades</h2>
        <p class="text-body-large">I - Diferenciação dos conteúdos previstos na ementa do componente curricular e que sejam registrados no PTE: Sim</p>
        <p class="text-body-large">II - Atendimento educacional individualizado realizado pelo professor do componente curricular: Sim</p>
        <p class="text-body-large">III - Dilação ou redução do prazo para a conclusão do curso: Sim</p>
        <p class="text-body-large">IV  - Reorganização e/ou equivalência de componente curricular: Sim</p>
        <p class="text-body-large">V - Definição de critérios diferenciados e adequados de avaliação, considerando as singularidades e especificidades dos estudantes: Sim</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">5. Componentes curriculares a serem flexibilizados</h2>
        <p class="text-body-large">Matemática III; Geografia III...</p>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">6. Informações adicionais</h2>
        <livewire:form.input type="textarea" appearance="surface" name="informações-adicionais" size="full" disabled value="Informações adicionais"/>
    </div>
</x-layouts.main>
