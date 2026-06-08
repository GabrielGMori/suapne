<x-layouts.main
    title="Atendimento Semanal com {{ $atendimento->estudante->nome }} - {{ $atendimento->data->format('d/m/Y') }}">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-title-large">Data do atendimento: {{ $atendimento->data->format('d/m/Y H:i') }}</h3>
            <h3 class="text-title-large">Feito por: {{ $atendimento->user->nome }}</h3>
        </div>
        <div class="flex justify-end">
            <x-button label="Exportar como PDF" color="tertiary" icon="file_export" />
        </div>
    </div>

    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
        <p>Nome: Ricardo Borges</p>
        <p>Curso/Turma: Informática 4</p>
        <p>Idade: 17 anos</p>
        <p class="mb-5">Local: CNAPNE-IFPR Campus Curitiba</p>
        <p>Perfil do Estudante:</p>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 mt-5">
            <p>Perfil do estudante<br>...<br>... <br>...</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do atendimento</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Registro do atendimento<br>...<br>... <br>...</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Encaminhamentos referentes ao estudante<br>...<br>... <br>...</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p>Observações do atendimento<br>...<br>... <br>...</p>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <x-button label="Voltar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('atendimentos.index')  }}" color="tertiary" />
    </div>
</x-layouts.main>
