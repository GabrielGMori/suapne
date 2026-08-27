<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateCnapneRequest;
use App\Http\Requests\UpdateProfessorRequest;

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

    public function updateCnapne(UpdateCnapneRequest $request, User $user)
    {
        $user->update([
            'nome' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()
            ->route('contas.cnapne.index')
            ->with('success', 'Conta da CNAPNE atualizada com sucesso!');
    }

    public function updateProfessor(UpdateProfessorRequest $request, User $user)
    {
        $user->update([
            'nome' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()
            ->route('contas.professor.index')
            ->with('success', 'Conta do professor atualizada com sucesso!');
    }
}
