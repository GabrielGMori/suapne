<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use Illuminate\Http\RedirectResponse;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::orderBy('nome', 'asc')->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Cadastrar Curso';
        $curso = new Curso();
        return view('cursos.form', compact('titulo', 'curso'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request) : RedirectResponse
    {
        Curso::create($request->validated());
        return redirect()->route('cursos.index')->with('status', 'Curso cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {   
        $titulo = 'Editar Curso';
        return view('cursos.form', compact('titulo', 'curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, Curso $curso) : RedirectResponse
    {
        $curso->update($request->validated());
        return redirect()->route('cursos.index')->with('status', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }    
}
