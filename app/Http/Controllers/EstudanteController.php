<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use Illuminate\Http\Request;
use App\Http\Requests\EstudanteRequest;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
class EstudanteController extends Controller
{
    public function index(Request $request)
    {
        $estudantes = Estudante::paginate(10);

        return view('estudantes.index', ['estudantes' => $estudantes]);
    }

    public function create(Request $request)
    {
        return view('estudantes.form');
    }

    public function store(EstudanteRequest $request) : RedirectResponse
    {
        Estudante::create($request->validated());

        return redirect()->route('estudantes.index')->with('status', 'Estudante cadastrado com sucesso!');
    }

    public function show(Request $request, Estudante $estudante)
    {
        return view('estudantes.show', ['estudante' => $estudante]);
    }

    public function edit(Request $request, Estudante $estudante)
    {
        return view('estudantes.form', ['estudante' => $estudante]);
    }

    public function update(EstudanteRequest $request, Estudante $estudante)
    {
        $estudante->update($request->validated());

        return redirect()->route('estudantes.show', $estudante)->with('status', 'Estudante atualizado com sucesso!');
    }

    public function destroy(Request $request, Estudante $estudante)
    {
        $estudante->delete();

        return redirect()->route('estudantes.index')->with('status', 'Estudante excluído com sucesso!');
    }

    public function restore(Request $request, Estudante $estudante)
    {
        $estudante->restore();

        return redirect()->route('estudantes.index', ['filter[excluido][0]' => 1])->with('status', 'Estudante restaurado com sucesso!');
    }
}
