<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\CnapneRequest;
use App\Http\Requests\ProfessorRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function perfil(Request $request)
    {
        return view('contas.perfil', ['user' => $request->user()]);
    }

    public function indexCnapne(Request $request)
    {
        abort_unless($request->user()->can('viewAny', User::class), 404);

        return view('contas.cnapne.index');
    }

    public function indexProfessor(Request $request)
    {
        abort_unless($request->user()->can('viewAny', User::class), 404);

        return view('contas.professor.index');
    }

    public function editCnapne(Request $request, User $user)
    {
        abort_unless($request->user()->can('update', $user), 404);

        return view('contas.cnapne.form', ['user' => $user]);
    }

    public function editProfessor(Request $request, User $user)
    {
        abort_unless($request->user()->can('update', $user), 404);

        return view('contas.professor.form', ['user' => $user]);
    }

    public function updateCnapne(CnapneRequest $request, User $user)
    {
        abort_unless($request->user()->can('update', $user), 404);

        $validated = $request->validated();

        $user->update($validated);

        return redirect()->route('contas.cnapne.index')->with('status', 'Conta da CNAPNE atualizada com sucesso!');
    }

    public function updateProfessor(ProfessorRequest $request, User $user)
    {
        abort_unless($request->user()->can('update', $user), 404);

        $validated = $request->validated();

        $user->update($validated);
        $user->disciplinas()->sync($validated['disciplinas'] ?? []);

        return redirect()->route('contas.professor.index')->with('status', 'Conta do professor atualizada com sucesso!');
    }
}
