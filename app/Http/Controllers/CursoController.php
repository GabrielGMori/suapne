<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;
use Illuminate\Http\RedirectResponse;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', Curso::class), 404);

        return view('cursos.index');
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->can('create', Curso::class), 404);

        return view('cursos.form');
    }

    public function store(CursoRequest $request) : RedirectResponse
    {
        abort_unless($request->user()->can('create', Curso::class), 404);

        Curso::create($request->validated());

        return redirect()->route('cursos.index')->with('status', 'Curso cadastrado com sucesso!');
    }

    public function edit(Request $request, Curso $curso)
    {
        abort_unless($request->user()->can('update', $curso), 404);

        return view('cursos.form', ['curso' => $curso]);
    }

    public function update(CursoRequest $request, Curso $curso) : RedirectResponse
    {
        abort_unless($request->user()->can('update', $curso), 404);

        $curso->update($request->validated());
        return redirect()->route('cursos.index',$curso)->with('status', 'Curso atualizado com sucesso!');
    }

    public function destroy(Request $request, Curso $curso)
    {
        abort_unless($request->user()->can('delete', $curso), 404);
    }
}
