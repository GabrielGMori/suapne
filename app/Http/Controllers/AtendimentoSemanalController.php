<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoSemanal;
use Illuminate\Http\Request;
use App\Http\Requests\AtendimentoSemanalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AtendimentoSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atendimentos = AtendimentoSemanal::paginate(10);
        return view('atendimentos.index', ['atendimentos'=> $atendimentos]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('atendimentos.form');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(AtendimentoSemanalRequest $request) : RedirectResponse
    {
       AtendimentoSemanal::create($request->validated());
       return redirect()->route('atendimentos.index')->with('status','Atendimento semanal cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AtendimentoSemanal $atendimento)
    {
       return view('atendimentos.show',['atendimento'=>$atendimento]);
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
