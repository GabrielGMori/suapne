<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitacaoRegistroRequest;
use App\Models\SolicitacaoRegistro;
use Hash;

class RegisterController extends Controller
{
    public function submit(SolicitacaoRegistroRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $solicitacao = SolicitacaoRegistro::create([...$validated, 'status' => StatusSolicitacaoRegistroEnum::PENDENTE]);
        $solicitacao->disciplinas()->sync($validated['campos']['disciplinas'] ?? null);

        return view('auth.cadastro.enviado');
    }

    public function accept(SolicitacaoRegistro $solicitacao)
    {
        $solicitacao->createUser();
        $solicitacao->delete();

        return redirect()->route('solicitacoes-registro.index')->with('status', "Usuário \"{$solicitacao->nome}\" cadastrado com sucesso!");
    }

    public function decline(SolicitacaoRegistro $solicitacao)
    {
        $solicitacao->delete();

        return redirect()->route('solicitacoes-registro.index')->with('status', 'Solicitação recusada com sucesso!');
    }
}
