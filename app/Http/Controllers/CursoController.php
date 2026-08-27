<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;
use Illuminate\Http\RedirectResponse;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::paginate(10);

        return view('cursos.index', ['cursos' => $cursos]);
    }

    public function create()
    {
        return view('cursos.form');
    }

    public function store(CursoRequest $request) : RedirectResponse
    {
        Curso::create($request->validated());

        return redirect()->route('cursos.index')->with('status', 'Curso cadastrado com sucesso!');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.form', ['curso' => $curso]);
    }

    public function update(CursoRequest $request, Curso $curso) : RedirectResponse
    {
        $curso->update($request->validated());
        return redirect()->route('cursos.index',$curso)->with('status', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
    }
}
