<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoSemanal;
use App\Models\Estudante;
use App\Http\Requests\AtendimentoSemanalRequest;
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
    }

    public function update(AtendimentoSemanalRequest $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('update', $atendimento), 404);
    }

    public function destroy(Request $request, AtendimentoSemanal $atendimento)
    {
        abort_unless($request->user()->can('delete', $atendimento), 404);
    }
}
