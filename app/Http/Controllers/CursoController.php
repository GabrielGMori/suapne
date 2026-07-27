<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;
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
        return view('cursos.form');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request) : RedirectResponse
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
        return view('cursos.form', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoRequest $request, Curso $curso) : RedirectResponse
    {
        $curso->update($request->validated());
        return redirect()->route('cursos.index',$curso)->with('status', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }    
}
