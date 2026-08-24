<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrevistaFamiliarRequest;
use Illuminate\Http\Request;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Http\RedirectResponse;

class EntrevistaFamiliarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Estudante $estudante)
    {
        return view('entrevistas-familiares.form',['estudante' => $estudante]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntrevistaFamiliarRequest $request, Estudante $estudante): RedirectResponse
    {
        EntrevistaFamiliar::create($request->validated());

        return redirect()->route('estudantes.show', ['estudante' => $estudante->id])->with('status', 'Entrevista familiar cadastrada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
