<?php

namespace App\Http\Controllers;
use App\Enums\RoleEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\Http\Requests\PlanoTrabalhoEstudanteRequest;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PlanoTrabalhoEstudanteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $count = $user->role === RoleEnum::PROFESSOR_REGULAR
            ? $user->planosTrabalhoProfessor->filter(fn($plano) => $plano->status === StatusPlanoTrabalhoEnum::PENDENTE || $plano->status === StatusPlanoTrabalhoEnum::DEVOLVIDO)->count()
            : PlanoTrabalhoEstudante::where('status', StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)->count();

        return view('planos-trabalho.index', ['count' => $count]);
    }

    public function create(?Estudante $estudante = null)
    {
        return view('planos-trabalho.form', ['estudanteId' => $estudante?->id]);
    }

    public function store(PlanoTrabalhoEstudanteRequest $request)
    {
        $validated = $request->validated();
        $professores = User::with('disciplinas')->whereIn('id', $validated['professores'])->get();

        DB::transaction(function () use ($validated, $professores) {
            foreach($validated['disciplinas'] as $disciplinaId) PlanoTrabalhoEstudante::create([...$validated,
                'disciplina_id' => $disciplinaId,
                'user_professor_id' => $professores->first(fn($prof) => $prof->disciplinas->contains('id', $disciplinaId))->id]);
        });

        return redirect()->route('planos-trabalho.index')->with('status', 'Planos de trabalho criado com sucesso!');
    }

    public function show(PlanoTrabalhoEstudante $planoTrabalho)
    {
        return view('planos-trabalho.show', ['planoTrabalho' => $planoTrabalho]);
    }

    public function edit()
    {
    }

    public function update(PlanoTrabalhoEstudanteRequest $request, PlanoTrabalhoEstudante $planoTrabalho)
    {
        $validated = $request->validated();
        $validated['campos'] = [
            ...($planoTrabalho->campos ?? []),
            ...($validated['campos'] ?? []),
        ];

        $planoTrabalho->update($validated);

        return redirect()->route('planos-trabalho.index')->with('status', 'Plano de trabalho atualizado com sucesso!');
    }

    public function destroy()
    {
    }

    public function preview(PlanoTrabalhoEstudanteRequest $request)
    {
        $validated = $request->validated();
        $professores = User::with('disciplinas')->whereIn('id', $validated['professores'])->get();
        $professor = $professores->first(
            fn ($professor) => $professor->disciplinas->contains('id', $validated['disciplinas'][0])
        );

        $planoTrabalho = new PlanoTrabalhoEstudante([
            ...$validated,
            'disciplina_id' => $validated['disciplinas'][0],
            'user_professor_id' => $professor->id,
        ]);
        $planoTrabalho->load(['estudante', 'disciplina', 'professor']);
        $previewDisciplinas = Disciplina::whereIn('id', $validated['disciplinas'])->pluck('nome', 'id')->toArray();

        return view('planos-trabalho.show', [
            'planoTrabalho' => $planoTrabalho,
            'preview' => true,
            'previewDisciplinas' => $previewDisciplinas,
            'previewProfessores' => $validated['professores'],
        ]);
    }

    public function changePreview(PlanoTrabalhoEstudanteRequest $request)
    {
        $validated = $request->validated();
        $planoTrabalho = new PlanoTrabalhoEstudante($validated);
        $planoTrabalho->disciplina_id = $validated['chosenDisciplina'] ?? $validated['previewDisciplinas'][0];
        $professores = User::with('disciplinas')->whereIn('id', $validated['professores'])->get();
        $professor = $professores->first(
            fn ($professor) => $professor->disciplinas->contains('id', $planoTrabalho->disciplina_id)
        );
        $planoTrabalho->user_professor_id = $professor->id;
        $planoTrabalho->load(['estudante', 'disciplina', 'professor']);

        return view('planos-trabalho.show', [
            'planoTrabalho' => $planoTrabalho,
            'preview' => true,
            'previewDisciplinas' => Disciplina::whereIn('id', $validated['previewDisciplinas'])->pluck('nome', 'id')->toArray(),
            'previewProfessores' => $validated['professores'],
        ]);
    }

    public function exportPdf(int $id)
    {
    }
}
