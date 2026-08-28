<?php

namespace App\Http\Controllers;
use App\Enums\RoleEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\Http\Requests\PlanoTrabalhoEstudanteRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlanoTrabalhoEstudanteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $count = $user->role === RoleEnum::PROFESSOR_REGULAR
            ? $user->planosTrabalhoProfessor->where('status', StatusPlanoTrabalhoEnum::PENDENTE)->count()
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

        foreach($validated['disciplinas'] as $disciplinaId) {
            $professorId = array_find($validated['professores'], fn($id) => User::find($id)->disciplinas->find($disciplinaId) !== null);
            PlanoTrabalhoEstudante::create([...$validated, 'disciplina_id' => $disciplinaId, 'user_professor_id' => $professorId]);
        }

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

    public function preview()
    {

    }

    public function exportPdf(int $id)
    {
    }
}
