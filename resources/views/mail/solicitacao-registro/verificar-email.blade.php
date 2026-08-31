<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $nome }}!

Use o código abaixo para verificar seu e-mail e confirmar seu cadastro no SUAPNE:

<x-mail::panel>
# {{ $code }}
</x-mail::panel>

**Atenção:** Caso você não tenha feito esta solicitação, pode ignorar este e-mail com segurança.

</x-mail::message>
