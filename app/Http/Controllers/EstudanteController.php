<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Http\Requests\EstudanteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EstudanteController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', Estudante::class), 404);

        return view('estudantes.index');
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->can('create', Estudante::class), 404);

        return view('estudantes.form');
    }

    public function store(EstudanteRequest $request) : RedirectResponse
    {
        abort_unless($request->user()->can('create', Estudante::class), 404);

        Estudante::create($request->validated());

        return redirect()->route('estudantes.index')->with('status', 'Estudante cadastrado com sucesso!');
    }

    public function show(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('view', $estudante), 404);

        return view('estudantes.show', ['estudante' => $estudante]);
    }

    public function edit(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('update', $estudante), 404);

        return view('estudantes.form', ['estudante' => $estudante]);
    }

    public function update(EstudanteRequest $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('update', $estudante), 404);

        $estudante->update($request->validated());

        return redirect()->route('estudantes.show', $estudante)->with('status', 'Estudante atualizado com sucesso!');
    }

    public function destroy(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('delete', $estudante), 404);

        $estudante->delete();

        return redirect()->route('estudantes.index')->with('status', 'Estudante excluído com sucesso!');
    }

    public function restore(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('restore', $estudante), 404);

        $estudante->restore();

        return redirect()->back()->with('status', 'Estudante restaurado com sucesso!');
    }
}
