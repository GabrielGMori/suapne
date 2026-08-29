<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitacaoRegistroRequest;
use App\Mail\SolicitacaoRegistroAceita;
use App\Mail\SolicitacaoRegistroRecusada;
use App\Models\SolicitacaoRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    public function accept(Request $request, SolicitacaoRegistro $solicitacao)
    {
        abort_unless($request->user()->can('update', $solicitacao), 404);

        $newUser = $solicitacao->createUser();
        $solicitacao->delete();

        Mail::to($newUser->email)->send(new SolicitacaoRegistroAceita($newUser));

        return redirect()->route('solicitacoes-registro.index')->with('status', "Usuário \"{$solicitacao->nome}\" cadastrado com sucesso!");
    }

    public function decline(Request $request, SolicitacaoRegistro $solicitacao)
    {
        abort_unless($request->user()->can('delete', $solicitacao), 404);

        Mail::to($solicitacao->email)->send(new SolicitacaoRegistroRecusada(
            nome: $solicitacao->nome,
            observacao: $request->input('observacao')
        ));

        $solicitacao->delete();

        return redirect()->route('solicitacoes-registro.index')->with('status', 'Solicitação recusada com sucesso!');
    }
}
