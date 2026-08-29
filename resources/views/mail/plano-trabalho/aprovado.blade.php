<x-mail::message>
<img src="{{ $message->embed(asset('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $notifiable->nome }}!

O seu plano de trabalho do estudante "**{{ $planoTrabalho->nome }}**" foi aprovado e está pronto para ser efetivado.

<x-mail::button :url="route('planos-trabalho.show', ['planoTrabalho' => $planoTrabalho])">
Ver plano de trabalho
</x-mail::button>

**Atenção:** O SUAPNE só pode ser acessado em um computador ligado à rede do IFPR Campus Curitiba.

</x-mail::message>
