<x-layouts.main title="{{ $atendimento->nome }}">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-title-large">Data do atendimento: {{ $atendimento->data->format('d/m/Y \à\s H:i') }}</h3>
            <h3 class="text-title-large">Feito por: {{ $atendimento->user->nome }}</h3>
        </div>
        <div class="flex justify-end">
            <x-button label="Exportar como PDF" target="_blank" color="tertiary" icon="file_export" type="link" :href="route('atendimentos.exportPdf', ['atendimento' => $atendimento,])"/>
        </div>
    </div>

    <div class="flex flex-col bg-surface rounded-lg p-5 mb-5 mt-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
        <p>Nome: {{$atendimento->estudante->nome}}</p>
        <p>Curso/Turma: {{$atendimento->estudante->curso->nome}} {{$atendimento->estudante->periodo}}</p>
        <p>Idade: {{ $atendimento->estudante->idade }} anos</p>
        <p class="mb-5">Local: {{ $atendimento->local }}</p>
        <p>Perfil do Estudante:</p>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 mt-5">
            <p class="whitespace-pre-line">{{$atendimento->campos['perfilDoEstudante'] ?? '---'}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do atendimento</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p class="whitespace-pre-line">{{$atendimento->campos['registroDoAtendimento'] ?? '---'}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p class="whitespace-pre-line">{{$atendimento->campos['encaminhamentos'] ?? '---'}}</p>
        </div>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5">
            <p class="whitespace-pre-line">{{$atendimento->campos['observacoesAdicionais'] ?? '---'}}</p>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.cancel label="Voltar" color="tertiary" fallback="atendimentos.index" />
        <x-button label="Editar" color="yellow" type="link" href="{{ route('atendimentos.edit', $atendimento) }}"/>
        <x-modal label="Excluir" icon="delete" color="red" title="Excluir Atendimento Semanal">
            <p class="mb-5 text-body-large">
                Tem certeza que deseja excluir este atendimento semanal?<br>
                Você poderá restaurá-lo posteriormente.
            </p>
            <div class="flex justify-end gap-3 mb-2">
                <x-button label="Cancelar" color="secondary" x-on:click="show=false" />
                <form action="{{ route('atendimentos.destroy', ['atendimento' => $atendimento]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <x-button label="Confirmar" type="submit" color="red" />
                </form>
            </div>
        </x-modal>
    </div>
</x-layouts.main>
