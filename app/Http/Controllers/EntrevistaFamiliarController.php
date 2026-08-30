<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrevistaFamiliarRequest;
use Illuminate\Http\Request;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class EntrevistaFamiliarController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', EntrevistaFamiliar::class), 404);
    }

    public function create(Request $request, Estudante $estudante)
    {
        abort_unless($request->user()->can('create', EntrevistaFamiliar::class), 404);

        return view('entrevistas-familiares.form',['estudante' => $estudante]);
    }

    public function store(EntrevistaFamiliarRequest $request, Estudante $estudante): RedirectResponse
    {
        abort_unless($request->user()->can('create', EntrevistaFamiliar::class), 404);

        EntrevistaFamiliar::create($request->validated());

        return redirect()->route('estudantes.show', ['estudante' => $estudante->id])->with('status', 'Entrevista familiar cadastrada com sucesso!');
    }

    public function show(Request $request, Estudante $estudante, EntrevistaFamiliar $entrevistaFamiliar)
    {
        abort_unless($request->user()->can('view', $entrevistaFamiliar), 404);

        return view('entrevistas-familiares.show',['estudante' => $estudante,'entrevistaFamiliar' => $entrevistaFamiliar]);
    }

    public function edit(Request $request, Estudante $estudante, EntrevistaFamiliar $entrevistaFamiliar)
    {
        abort_unless($request->user()->can('update', $entrevistaFamiliar), 404);

        return view('entrevistas-familiares.form', [
            'estudante' => $estudante,
            'entrevistaFamiliar' => $entrevistaFamiliar,
        ]);
    }

    public function update(EntrevistaFamiliarRequest $request, Estudante $estudante, EntrevistaFamiliar $entrevistaFamiliar): RedirectResponse
    {
        abort_unless($request->user()->can('update', $entrevistaFamiliar), 404);

        $entrevistaFamiliar->update($request->validated());

        return redirect()->route('estudantes.show', [
            'estudante' => $estudante,
        ])->with('status', 'Entrevista familiar atualizada com sucesso!');
    }

    public function destroy(Request $request, Estudante $estudante, EntrevistaFamiliar $entrevistaFamiliar): RedirectResponse
    {
        abort_unless($request->user()->can('delete', $entrevistaFamiliar), 404);

        $entrevistaFamiliar->delete();

        return redirect()->route('estudantes.show', ['estudante' => $estudante])->with('status', 'Entrevista familiar excluída com sucesso!');
    }
    public function exportPdf(Estudante $estudante,EntrevistaFamiliar $entrevistaFamiliar)
    {
        return Pdf::loadView('entrevistas-familiares.pdf', ['entrevistaFamiliar'=> $entrevistaFamiliar])->stream($entrevistaFamiliar->estudante->nome.'.pdf');
    }
}
