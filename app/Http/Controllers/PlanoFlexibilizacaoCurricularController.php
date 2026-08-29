<?php

namespace App\Http\Controllers;

use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Http\Requests\PlanoFlexibilizacaoCurricularRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanoFlexibilizacaoCurricularController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', PlanoFlexibilizacaoCurricular::class), 404);

        $count = Estudante::doesntHave('planosFlexibilizacaoCurricular')->count();

        return view('planos-flexibilizacao.index', ['count' => $count]);
    }

    public function create(Request $request, ?Estudante $estudante = null)
    {
        abort_unless($request->user()->can('create', PlanoFlexibilizacaoCurricular::class), 404);

        return view('planos-flexibilizacao.form', ['estudanteId' => $estudante?->id]);
    }

    public function store(PlanoFlexibilizacaoCurricularRequest $request): RedirectResponse
    {
        abort_unless($request->user()->can('create', PlanoFlexibilizacaoCurricular::class), 404);

        PlanoFlexibilizacaoCurricular::create($request->validated());

        return redirect()->route('planos-flexibilizacao.index')->with('status', 'Plano de Flexibilização cadastrado com sucesso!');
    }

    public function show(Request $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('view', $planoFlexibilizacao), 404);

        return view('planos-flexibilizacao.show', ['planoFlexibilizacao' => $planoFlexibilizacao]);
    }

    public function edit(Request $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('update', $planoFlexibilizacao), 404);
    }

    public function update(PlanoFlexibilizacaoCurricularRequest $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('update', $planoFlexibilizacao), 404);
    }

    public function destroy(Request $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('delete', $planoFlexibilizacao), 404);
    }

    public function exportPdf(Request $request, int $id)
    {
        $planoFlexibilizacao = PlanoFlexibilizacaoCurricular::with('estudante.curso')->findOrFail($id);

        abort_unless($request->user()->can('view', $planoFlexibilizacao), 404);

        $pdf = Pdf::loadView('planos-flexibilizacao.show', compact('planoFlexibilizacao'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("plano_flexibilizacao_{$planoFlexibilizacao->id}.pdf");
    }
}
