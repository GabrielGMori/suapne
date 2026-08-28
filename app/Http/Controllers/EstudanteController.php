<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Http\Requests\EstudanteRequest;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
class EstudanteController extends Controller
{
    public function index()
    {
        return view('estudantes.index');
    }

    public function create()
    {
        return view('estudantes.form');
    }

    public function store(EstudanteRequest $request) : RedirectResponse
    {
        Estudante::create($request->validated());

        return redirect()->route('estudantes.index')->with('status', 'Estudante cadastrado com sucesso!');
    }

    public function show(Estudante $estudante)
    {
        return view('estudantes.show', ['estudante' => $estudante]);
    }

    public function edit(Estudante $estudante)
    {
        return view('estudantes.form', ['estudante' => $estudante]);
    }

    public function update(EstudanteRequest $request, Estudante $estudante)
    {
        $estudante->update($request->validated());

        return redirect()->route('estudantes.show', $estudante)->with('status', 'Estudante atualizado com sucesso!');
    }

    public function destroy(Estudante $estudante)
    {
        $estudante->delete();

        return redirect()->route('estudantes.index')->with('status', 'Estudante excluído com sucesso!');
    }

    public function restore(Estudante $estudante)
    {
        $estudante->restore();

        return redirect()->route('estudantes.index', ['filter[excluido][0]' => 1])->with('status', 'Estudante restaurado com sucesso!');
    }
}
