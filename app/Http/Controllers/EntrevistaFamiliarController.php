<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrevistaFamiliarRequest;
use Illuminate\Http\Request;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Http\RedirectResponse;

class EntrevistaFamiliarController extends Controller
{
    public function index()
    {
    }

    public function create(Estudante $estudante)
    {
        return view('entrevistas-familiares.form',['estudante' => $estudante]);
    }

    public function store(EntrevistaFamiliarRequest $request, Estudante $estudante): RedirectResponse
    {
        EntrevistaFamiliar::create($request->validated());

        return redirect()->route('estudantes.show', ['estudante' => $estudante->id])->with('status', 'Entrevista familiar cadastrada com sucesso!');
    }

    public function show(Estudante $estudante, EntrevistaFamiliar $entrevistaFamiliar)
    {
        return view('entrevistas-familiares.show',['estudante' => $estudante,'entrevistaFamiliar' => $entrevistaFamiliar]);
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
