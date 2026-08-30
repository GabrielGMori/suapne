<?php

use Livewire\Component;
use App\Models\Estudante;
use App\Models\Disciplina;
use App\Models\PlanoTrabalhoEstudante;

new class extends Component {
    public ?PlanoTrabalhoEstudante $planoTrabalho;

    public null|string|array $estudanteId = '';
    public ?Estudante $estudante = null;

    public ?array $displayDisciplinas = null;
    public array $selectedDisciplinas = [];

    public ?array $displayProfessores = null;
    public array $selectedProfessores = [];

    public function mount(): void
    {
        $this->estudanteId = old('estudante_id', $this->planoTrabalho->estudante_id ?? ($this->estudanteId ?? ''));
        if (filled($this->estudanteId))
            $this->updatedEstudanteId($this->estudanteId);

        $this->selectedDisciplinas = old('disciplinas', isset($this->planoTrabalho) ? [$this->planoTrabalho->disciplina_id] : $this->selectedDisciplinas);
        if (filled($this->selectedDisciplinas))
            $this->updatedSelectedDisciplinas($this->selectedDisciplinas);

        $this->selectedProfessores = old('professores', isset($this->planoTrabalho) ? [$this->planoTrabalho->user_professor_id] : $this->selectedProfessores);
    }

    public function updatedEstudanteId($estId)
    {
        $id = is_array($estId) ? $estId[0] : $estId;
        $this->estudante = Estudante::find($id);

        $estudanteDisciplinas = $this->estudante?->disciplinas;
        $this->displayDisciplinas = $estudanteDisciplinas ? $estudanteDisciplinas->pluck('nome', 'id')->toArray() : [];
        $this->selectedDisciplinas = [];
        $this->selectedProfessores = [];

        $plano = $this->estudante->planosFlexibilizacaoCurricular?->last();
        if ($plano === null)
            return;

        $this->selectedDisciplinas = $plano->campos['componentesCurriculares'];
        $this->updatedSelectedDisciplinas($this->selectedDisciplinas);
    }

    public function updatedSelectedDisciplinas($discs)
    {
        if (empty($discs)) {
            $this->displayProfessores = [];
            $this->selectedProfessores = [];
            return;
        }

        $disciplinas = Disciplina::with(['users:id,nome'])->whereIn('id', $discs)->get(['id', 'nome']);
        $professores = [];

        foreach ($disciplinas as $disciplina) {
            foreach ($disciplina->users as $professor) {
                $professores[$professor->id]['nome'] = $professor->nome;
                $professores[$professor->id]['disciplinas'][] = $disciplina->nome;
            }
        }

        $this->displayProfessores = [];

        foreach ($professores as $professorId => $professor) {
            $this->displayProfessores[$professorId] =
                $professor['nome'] .
                ' (' .
                implode(', ', $professor['disciplinas']) .
                ')';
        }

        $this->selectedProfessores = array_values(
            array_filter(
                $this->selectedProfessores,
                fn($professorId) =>
                array_key_exists($professorId, $this->displayProfessores)
            )
        );
    }
};
?>

<form action="{{ !$planoTrabalho ? route('planos-trabalho.store') : route('planos-trabalho.update', ['planoTrabalho' => $planoTrabalho]) }}" method="POST">
    @if($planoTrabalho)
        @method('PUT')
    @endif
    @csrf

    <div wire:ignore>
        <h2 class="flex gap-5 mb-5 text-display-small">Período de realização:
            <x-form.input type="date" size="small" name="periodo_inicio" appearance="outlined"
                :value="$planoTrabalho?->periodo_inicio" />
            a
            <x-form.input type="date" size="small" name="periodo_fim" appearance="outlined"
                :value="$planoTrabalho?->periodo_fim" />
        </h2>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>

        <div wire:key="selects-wrapper">
            <livewire:form.select type="select" label="Estudante" name="estudante_id" appearance="outlined"
                placeholder="Selecionar" :options="Estudante::pluck('nome', 'id')->toArray()"
                wire:model.live="estudanteId" :disabled="filled($this->planoTrabalho)" />

            <livewire:form.select type="multiselect" label="Componentes curriculares" name="disciplinas"
                appearance="outlined" :placeholder="$estudante !== null ? 'Selecionar' : 'Escolha um estudante'"
                :options="$displayDisciplinas ?? []" :disabled="$this->planoTrabalho || $estudante === null"
                wire:key="disciplinas-select-{{ $this->estudante?->id }}" wire:model.live="selectedDisciplinas" />

            <livewire:form.select type="multiselect" label="Docentes" name="professores" appearance="outlined"
                size="xxlarge" :placeholder="filled($selectedDisciplinas) ? 'Selecionar' : 'Escolha um ou mais componentes curriculares'"
                :disabled="$this->planoTrabalho || !filled($selectedDisciplinas)"
                no-result-message="Nenhum docente relacionado aos componentes selecionados foi encontrado"
                wire:key="professores-select-{{ $this->estudante?->id }}" wire:model.live="selectedProfessores"
                :options="$displayProfessores ?? []" />

            @if($this->planoTrabalho)
                <p class="text-label-medium my-5">Os campos acima não podem ser editados</p>
            @endif
        </div>

        <div wire:ignore>
            <x-form.input label="Carga horária de atendimento (opcional)" name="campos[cargaHoraria]"
                appearance="outlined" wire:ignore :value="$planoTrabalho?->campos['cargaHoraria'] ?? null" />
            <x-form.input label="Local" name="campos[local]" appearance="outlined" wire:ignore
                :value="$planoTrabalho?->campos['local'] ?? null" />
        </div>
    </div>

    <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5" wire:ignore>
        <h2 class="text-display-small">2. Particularidades do estudante </h2>
        <x-form.input type="textarea" name="campos[particularidadesEstudante]" appearance="outlined" size="full"
            :value="$planoTrabalho?->campos['particularidadesEstudante'] ?? null" />
    </div>


    <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
        <h2 class="text-display-small"> 3. Conteúdos do componente curricular que necessitam de adaptação e/ou
            flexibilização: </h2>
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5 border border-on-surface">
            @if(!$planoTrabalho)
                <p class="text-label-large">
                    Preenchimento automático com base nas ementas dos componentes curriculares selecionados
                </p>
            @else
                <p>{{ $planoTrabalho->disciplina->ementa }}</p>
            @endif
        </div>
    </div>

    <input type="hidden" name="status" value="PENDENTE">

    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" color="red" type="link"
            href="{{ url()->previous() !== url()->current() ? url()->previous() : route('planos-trabalho.index') }}" />

        <x-button label="Pré-visualização" color="tertiary" type="submit"
            formaction="{{ route('planos-trabalho.preview') }}" formmethod="POST" formtarget="_blank" />

        <x-button :label="$planoTrabalho ? 'Confirmar edições' : 'Enviar para docentes'" type="submit" />
    </div>
</form>
