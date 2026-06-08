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
        <p>Necessidade educacional específica:</p>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 mt-5">
            <p>Necessidade educacional específica <br>...<br>...<br>...</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular</h2>
        <h3 class="text-body-large text-secondary-accent">(Registrar todas as ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular)</h3>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Histórico de ações pedagógicas já realizadas e justificativa de implementação da flexibilização curricular <br>...<br>... <br>...</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Atendimento multiprofissional</h2>
        <h3 class="text-body-large text-secondary-accent">Profissionais, instituições ou serviços (internos ou externos ao IFPR) que fazem o acompanhamento do estudante</h3>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Atendimento multiprofissional<br>...<br>... <br>...</p>
        </div>
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
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Informações adicionais<br>...<br>... <br>...</p>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <x-button label="Voltar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-flexibilizacao.index')  }}" color="tertiary" />
    </div>
</x-layouts.main>
