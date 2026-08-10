<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use Illuminate\Http\Request;
use App\Http\Requests\EstudanteRequest;
use Illuminate\Http\RedirectResponse;

class EstudanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', Estudante::class), 401);

        $estudantes = Estudante::orderBy('nome')->paginate(10);

        return view('estudantes.index', ['estudantes' => $estudantes, 'filtersExpanded' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        abort_unless($request->user()->can('create', Estudante::class), 401);

        return view('estudantes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstudanteRequest $request) : RedirectResponse
    {
        abort_unless($request->user()->can('create', Estudante::class), 401);

        Estudante::create($request->validated());

        return redirect()->route('estudantes.index')->with('status', 'Estudante cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('view', $estudante), 401);

        return view('estudantes.show', ['estudante' => $estudante]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('update', $estudante), 401);

        return view('estudantes.form', ['estudante' => $estudante]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstudanteRequest $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('update', $estudante), 401);

        $estudante->update($request->validated());
        
        return redirect()->route('estudantes.show', $estudante)->with('status', 'Estudante atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('delete', $estudante), 401);

        $estudante->delete();

        return redirect()->route('estudantes.index')->with('status', 'Estudante excluído com sucesso!');
    }

    public function restore(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('restore', $estudante), 401);

        $estudante->restore();

        return redirect()->route('estudantes.index', ['filter[excluido][0]' => 1])->with('status', 'Estudante restaurado com sucesso!');
    }
}
