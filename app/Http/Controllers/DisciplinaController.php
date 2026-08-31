<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisciplinaRequest;
use App\Models\Disciplina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', Disciplina::class), 404);

        return view('disciplinas.index');
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->can('create', Disciplina::class), 404);

        return view('disciplinas.form');
    }

    public function store(DisciplinaRequest $request) : RedirectResponse
    {
        abort_unless($request->user()->can('create', Disciplina::class), 404);

        Disciplina::create($request->validated());

        return redirect()->route('disciplinas.index')->with('status', 'Disciplina cadastrada com sucesso!');
    }

    public function edit(Request $request, Disciplina $disciplina)
    {
        abort_unless($request->user()->can('update', $disciplina), 404);

        return view('disciplinas.form', ['disciplina' => $disciplina]);
    }

    public function update(DisciplinaRequest $request, Disciplina $disciplina) : RedirectResponse
    {
        abort_unless($request->user()->can('update', $disciplina), 404);

        $disciplina->update($request->validated());

        return redirect()->route('disciplinas.index')->with('status', 'Disciplina atualizada com sucesso!');
    }

    public function destroy(Request $request, Disciplina $disciplina)
    {
        abort_unless($request->user()->can('delete', $disciplina), 404);
    }
};
