<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        return view('contas.cnapne.form', compact('user'));
    }

    public function editProfessor(User $user)
    {
        return view('contas.professor.form', compact('user'));
    }

    public function updateCnapne(Request $request, User $user)
    {
        $user->update([
            'nome' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()
            ->route('contas.cnapne.index')
            ->with('success', 'Conta da CNAPNE atualizada com sucesso!');
    }

    public function updateProfessor(Request $request, User $user)
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