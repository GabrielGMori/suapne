<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $newUser->nome }}!

Sua solicitação de registro no SUAPNE foi aceita e seu cadastro está ativo.

Você pode agora logar em usa conta acessando o SUAPNE em um computador ligado à rede do IFPR Campus Curitiba.

<x-mail::button :url="route('login')">
Página de login
</x-mail::button>

**Atenção:** Caso você não tenha feito esta solicitação, isso pode indicar que sua conta de e-mail foi acessada por terceiros. Recomendamos verificar a segurança do seu e-mail e, se necessário, alterar sua senha.

</x-mail::message>
