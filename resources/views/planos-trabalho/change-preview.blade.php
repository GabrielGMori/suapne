@props(['planoTrabalho', 'previewDisciplinas' => [], 'previewProfessores' => []])

<form action="{{ route('planos-trabalho.change-preview') }}" method="POST" class="flex gap-2">
    @csrf
    <input type="hidden" name="status" value="{{ $planoTrabalho->status->value }}">
    <input type="hidden" name="periodo_inicio" value="{{ $planoTrabalho->periodo_inicio->toDateString() }}">
    <input type="hidden" name="periodo_fim" value="{{ $planoTrabalho->periodo_fim->toDateString() }}">
    <input type="hidden" name="estudante_id" value="{{ $planoTrabalho->estudante_id }}">

    @foreach ($previewDisciplinas as $disciplinaId => $disciplinaNome)
        <input type="hidden" name="disciplinas[]" value="{{ $disciplinaId }}">
    @endforeach
    @foreach ($previewProfessores as $professorId)
        <input type="hidden" name="professores[]" value="{{ $professorId }}">
    @endforeach
    @foreach (($planoTrabalho->campos ?? []) as $campo => $valor)
        <input type="hidden" name="campos[{{ $campo }}]" value="{{ $valor }}">
    @endforeach
    @foreach (array_keys($previewDisciplinas) as $disciplinaId)
        <input type="hidden" name="previewDisciplinas[]" value="{{ $disciplinaId }}">
    @endforeach

    <livewire:form.select name="chosenDisciplina" :options="$previewDisciplinas" appearance="outlined"
        size="small" :value="$planoTrabalho->disciplina->id" />
    <x-button label="Atualizar" size="dynamic" type="submit" />
</form>
