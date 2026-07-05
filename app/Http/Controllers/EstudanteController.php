<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Http\Requests\StoreEstudanteRequest;
use App\Http\Requests\UpdateEstudanteRequest;
use Illuminate\Http\RedirectResponse;

class EstudanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudantes = Estudante::orderBy('nome')->paginate(10);

        return view('estudantes.index', compact('estudantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudantes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstudanteRequest $request) : RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = 'storage/' . $request->file('avatar')->store('img/uploads/avatars', 'public');
        }

        Estudante::create($data);

        return redirect()->route('estudantes.index')->with('status', 'Estudante cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudante $estudante)
    {
        return view('estudantes.show', compact('estudante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudante $estudante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstudanteRequest $request, Estudante $estudante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudante $estudante)
    {
        //
    }
}
