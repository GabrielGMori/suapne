<?php

namespace App\Http\Controllers;

use App\Models\PlanoFlexibilizacaoCurricular;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanoFlexibilizacaoCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planos = PlanoFlexibilizacaoCurricular::orderBy('nome','asc')->paginate(10);
        return view('planos-flexibilizacao.index', compact('planos'));
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planos-flexibilizacao.form');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       PlanoFlexibilizacaoCurricular::create($request->validated());

        return redirect()->route('planos-flexibilizacao.index')->with('status', 'Plano de Flexibilização cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanoFlexibilizacaoCurricular $planosFlexibilizacao)
    {   
        return view('planos-flexibilizacao.show', ['planoFlexibilizacao' => $planosFlexibilizacao]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {   
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    } 
}
