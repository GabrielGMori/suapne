<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoSemanal;
use App\Models\Estudante;
use App\Http\Requests\AtendimentoSemanalRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AtendimentoSemanalController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', AtendimentoSemanal::class), 404);

        return view('atendimentos.index');
    }

    public function create(Request $request, ?Estudante $estudante = null)
    {
        abort_unless($request->user()->can('create', AtendimentoSemanal::class), 404);

        return view('atendimentos.form', ['estudanteId' => $estudante?->id]);
    }

    public function store(AtendimentoSemanalRequest $request) : RedirectResponse
    {
        abort_unless($request->user()->can('create', AtendimentoSemanal::class), 404);

        AtendimentoSemanal::create($request->validated());
        return redirect()->route('atendimentos.index')->with('status','Atendimento semanal cadastrado com sucesso!');
    }

    public function show(Request $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('view', $atendimento), 404);

        return view('atendimentos.show', ['atendimento' => $atendimento]);
    }

    public function edit(Request $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('update', $atendimento), 404);
        return view('atendimentos.form', ['atendimento' => $atendimento]);
    }

    public function update(AtendimentoSemanalRequest $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('update', $atendimento), 404);
        $atendimento->update($request->validated());
        return redirect()->route('atendimentos.index')->with('status','Atendimento semanal editado com sucesso!');
    }

    public function destroy(Request $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('delete', $atendimento), 404);
        $atendimento->delete();
        return redirect()->route('atendimentos.index')->with('status','Atendimento semanal excluido com sucesso!');
    }

    public function restore(Request $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('restore', $atendimento), 404);
        $atendimento->restore();
        return redirect()->back()->with('status','Atendimento semanal restaurado com sucesso!');
    }
    public function exportPdf(AtendimentoSemanal $atendimento)
    {
        return Pdf::loadView('atendimentos.pdf', ['atendimento'=> $atendimento])->stream($atendimento->estudante->nome.'.pdf');
    }
}
