<?php

namespace App\Http\Controllers;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $disciplinas = Disciplina::all(); 
        
        return view('disciplinas.index',  ['disciplinas' => $disciplinas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $nome = $request->input('nome');
    $ementa = $request->input('ementa');
    $curso_id = $request->input('curso_id');

    $disciplina = Disciplina::create([
        'nome'     => $nome,
        'curso_id' => $curso_id,
        'ementa'   => $ementa,
    ]);

    return redirect()->route('disciplinas.index');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $disciplina = Disciplina::findOrFail($id);
      
      return view('disciplinas.form', ['disciplina' => $disciplina]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $disciplina = Disciplina::findOrFail($id);

        $disciplina->update([
        'nome'     => $request->input('nome'),
        'ementa'   => $request->input('ementa'),
        'curso_id' => $request->input('curso_id'),
    ]);
    return redirect()->route('disciplinas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $disciplina->delete();

        return redirect()->route('disciplinas.index');
    }
};
