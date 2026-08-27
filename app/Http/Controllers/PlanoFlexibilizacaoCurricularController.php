<?php

namespace App\Http\Controllers;

use App\Models\PlanoFlexibilizacaoCurricular;
use App\Http\Requests\PlanoFlexibilizacaoCurricularRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanoFlexibilizacaoCurricularController extends Controller
{
    public function index()
    {
        $planos = PlanoFlexibilizacaoCurricular::paginate(10);

        return view('planos-flexibilizacao.index', ['planos' => $planos]);
    }

    public function create()
    {
        return view('planos-flexibilizacao.form');
    }

    public function store(PlanoFlexibilizacaoCurricularRequest $request): RedirectResponse
    {
        PlanoFlexibilizacaoCurricular::create($request->validated());

        return redirect()->route('planos-flexibilizacao.index')
            ->with('status', 'Plano de Flexibilização cadastrado com sucesso!');
    }

    public function show(PlanoFlexibilizacaoCurricular $planosFlexibilizacao)
    {
        return view('planos-flexibilizacao.show', ['planoFlexibilizacao' => $planosFlexibilizacao]);
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

    public function exportPdf(int $id)
    {
        $planoFlexibilizacao = PlanoFlexibilizacaoCurricular::with('estudante.curso')->findOrFail($id);

        $pdf = Pdf::loadView('planos-flexibilizacao.show', compact('planoFlexibilizacao'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("plano_flexibilizacao_{$planoFlexibilizacao->id}.pdf");
    }
}
