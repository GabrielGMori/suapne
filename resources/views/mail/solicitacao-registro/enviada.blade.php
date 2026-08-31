<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $nome }}!

Sua solicitação de registro no SUAPNE foi enviada e entrou na fila para ser avaliada por um de nossos servidores.

Você receberá um novo e-mail quando ela for aceita ou recusada.

Desde já, obrigado pela paciência!

Caso você não tenha feito esta solicitação, isso pode indicar que sua conta de e-mail foi acessada por terceiros. Recomendamos verificar a segurança do seu e-mail e, se necessário, alterar sua senha.

**Atenção:** O SUAPNE só pode ser acessado em um computador ligado à rede do IFPR Campus Curitiba.

</x-mail::message>
