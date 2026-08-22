<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use Illuminate\Http\Request;

class ObservacaoEstudanteController extends Controller
{
    public function store(Request $request, Estudante $estudante)
    {
        $request->validate([
            'observacao' => 'required|string|max:1000',
        ]);

        $estudante->observacoes()->create([
            'observacao' => $request->input('observacao'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('estudantes.show', $estudante)->with('status', 'Observação adicionada com sucesso!');
    }

    public function destroy(Request $request, Estudante $estudante, ObservacaoEstudante $observacaoEstudante) 
    {
        $observacaoEstudante->delete();

        return redirect()->back()->with('status','Observação removida com sucesso!');
    }
}
