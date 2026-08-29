<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $nome }}!

Sua solicitação de registro no SUAPNE foi recusada.

@if(!empty($observacao))
<h1 style="margin-top: 30px">Observação adicionada ao recusar:</h1>

<p style="white-space: pre-line;">{{ $observacao }}</p>
@endif

**Atenção:** Caso você não tenha feito esta solicitação, recomendamos que verifique seu e-mail e altere sua senha.

</x-mail::message>
