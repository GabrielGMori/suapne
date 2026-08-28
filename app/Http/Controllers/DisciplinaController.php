<?php

namespace App\Http\Controllers;
use App\Http\Requests\DisciplinaRequest;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class DisciplinaController extends Controller
{
    public function index()
    {
        return view('disciplinas.index');
    }

    public function create()
    {
        return view('disciplinas.form');
    }

  public function store(DisciplinaRequest $request)
    {
        Disciplina::create($request->validated());

        return redirect()->route('disciplinas.index')->with('status', 'Disciplina cadastrada com sucesso!');;
    }

    public function edit(Disciplina $disciplina)
    {
        return view('disciplinas.form', ['disciplina' => $disciplina]);
    }

    public function update(DisciplinaRequest $request, Disciplina $disciplina)
    {
        $disciplina->update($request->validated());

        return redirect()->route('disciplinas.index')->with('status', 'Disciplina atualizada com sucesso!');
    }

    public function destroy(Disciplina $disciplina)
    {

    }
};
