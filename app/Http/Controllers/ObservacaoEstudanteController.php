<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Models\ObservacaoEstudante;
use App\Http\Requests\ObservacaoEstudanteRequest;
use Illuminate\Http\Request;

class ObservacaoEstudanteController extends Controller
{
    public function store(ObservacaoEstudanteRequest $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('create', ObservacaoEstudante::class), 404);

        $estudante->observacoes()->create([
            'observacao' => $request->input('observacao'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('estudantes.show', $estudante)->with('status', 'Observação adicionada com sucesso!');
    }

    public function destroy(Request $request, Estudante $estudante, ObservacaoEstudante $observacaoEstudante)
    {
        abort_unless($request->user()->can('delete', $observacaoEstudante), 404);

        $observacaoEstudante->delete();

        return redirect()->back()->with('status','Observação removida com sucesso!');
    }
}
