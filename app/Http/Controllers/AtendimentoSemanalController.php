<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoSemanal;
use App\Models\Estudante;
use App\Http\Requests\AtendimentoSemanalRequest;
use Illuminate\Http\RedirectResponse;

class AtendimentoSemanalController extends Controller
{
    public function index()
    {
        $atendimentos = AtendimentoSemanal::paginate(10);
        return view('atendimentos.index', ['atendimentos'=> $atendimentos]);
    }

    public function create(?Estudante $estudante = null)
    {
        return view('atendimentos.form', ['estudanteId' => $estudante?->id]);
    }

    public function store(AtendimentoSemanalRequest $request) : RedirectResponse
    {
       AtendimentoSemanal::create($request->validated());
       return redirect()->route('atendimentos.index')->with('status','Atendimento semanal cadastrado com sucesso!');
    }

    public function show(AtendimentoSemanal $atendimento)
    {
       return view('atendimentos.show',['atendimento'=>$atendimento]);
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
