<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\CnapneRequest;
use App\Http\Requests\ProfessorRequest;

class UserController extends Controller
{
    public function indexCnapne()
    {
        return view('contas.cnapne.index');
    }

    public function indexProfessor()
    {
        return view('contas.professor.index');
    }

    public function editCnapne(User $user)
    {
        return view('contas.cnapne.form', ['user' => $user]);
    }

    public function editProfessor(User $user)
    {
        return view('contas.professor.form', ['user' => $user]);
    }

    public function updateCnapne(CnapneRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update($validated);

        return redirect()->route('contas.cnapne.index')->with('status', 'Conta da CNAPNE atualizada com sucesso!');
    }

    public function updateProfessor(ProfessorRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update($validated);
        $user->disciplinas()->sync($validated['disciplinas'] ?? []);

        return redirect()->route('contas.professor.index')->with('status', 'Conta do professor atualizada com sucesso!');
    }
}
