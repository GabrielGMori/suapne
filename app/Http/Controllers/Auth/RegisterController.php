<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitacaoRegistroRequest;
use App\Mail\SolicitacaoRegistroAceita;
use App\Mail\SolicitacaoRegistroEnviada;
use App\Mail\SolicitacaoRegistroRecusada;
use App\Mail\VerificarEmail;
use App\Models\SolicitacaoRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
    public function submit(SolicitacaoRegistroRequest $request)
    {
        $validated = $request->validated();
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put("cadastro_pendente:{$validated['email']}", Crypt::encrypt([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'code_hash' => hash('sha256', $code),
            'attempts' => 0,
        ]), now()->addMinutes(15));

        Mail::to($validated['email'])->send(new VerificarEmail($validated['nome'], $code));
        session(['cadastro_email' => $validated['email']]);

        return redirect()->route('cadastro.verify.form');
    }

    public function verifyForm()
    {
        if (!filled(session('cadastro_email')))
            return redirect()->route('login');

        return view('auth.cadastro.verificar');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate(['code' => 'required|string|size:6']);
        $email = session('cadastro_email');

        if (!filled($email)) return redirect()->route('login');

        $cacheKey = "cadastro_pendente:{$email}";
        $encrypted = Cache::get($cacheKey);
        if (!$encrypted) return back()->withErrors(['code' => 'Código expirado ou inválido.']);

        $cadastro_pendente = Crypt::decrypt($encrypted);
        if (!hash_equals($cadastro_pendente['code_hash'], hash('sha256', $validated['code']))) {
            $cadastro_pendente['attempts']++;
            Cache::put($cacheKey, Crypt::encrypt($cadastro_pendente), now()->addMinutes(15));
            return back()->withErrors(['code' => 'Código expirado ou inválido.']);
        }

        $solicitacao = SolicitacaoRegistro::create([...$cadastro_pendente, 'status' => StatusSolicitacaoRegistroEnum::PENDENTE]);
        $solicitacao->disciplinas()->sync($cadastro_pendente['campos']['disciplinas'] ?? null);

        Mail::to($email)->send(new SolicitacaoRegistroEnviada($cadastro_pendente['nome']));

        Cache::forget($cacheKey);
        session()->forget('cadastro_email');

        return redirect()->route('cadastro.enviado');
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
