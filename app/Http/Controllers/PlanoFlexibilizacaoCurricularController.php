<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoFlexibilizacaoCurricularRequest;
use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        PlanoFlexibilizacaoCurricular::create($request->dadosValidados());

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
        return view('planos-flexibilizacao.form', ['planoFlexibilizacao' => $planoFlexibilizacao]);
    }

    public function update(PlanoFlexibilizacaoCurricularRequest $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao): RedirectResponse
    {
        abort_unless($request->user()->can('update', $planoFlexibilizacao), 404);
        $planoFlexibilizacao->update($request->dadosValidados());

        return redirect()->route('planos-flexibilizacao.index', ['planoFlexibilizacao' => $planoFlexibilizacao])->with('status', 'Plano de Flexibilização atualizado com sucesso!');
    }

    public function destroy(Request $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('delete', $planoFlexibilizacao), 404);
        $planoFlexibilizacao->delete();

        return redirect()->route('planos-flexibilizacao.index')->with('status', 'Plano de Flexibilização excluído com sucesso!');
    }

    public function restore(Request $request, PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        abort_unless($request->user()->can('restore', $planoFlexibilizacao), 404);
        $planoFlexibilizacao->restore();

        return redirect()->back()->with('status','Plano de Flexibilização restaurado com sucesso!');
    }

    public function exportPdf(PlanoFlexibilizacaoCurricular $planoFlexibilizacao)
    {
        return Pdf::loadView('planos-flexibilizacao.pdf', ['planoFlexibilizacao' => $planoFlexibilizacao])->stream($planoFlexibilizacao->estudante->nome.'.pdf');
    }
}
