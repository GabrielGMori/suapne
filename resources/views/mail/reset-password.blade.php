<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $notifiable->nome }}!

Recebemos uma solicitação de redefinição de senha para sua conta do SUAPNE.

<x-mail::button :url="$url">
Modificar Senha
</x-mail::button>

Este link expira em 60 minutos.

**Atenção:** Caso você não tenha feito esta solicitação, pode ignorar este e-mail com segurança.

</x-mail::message>
