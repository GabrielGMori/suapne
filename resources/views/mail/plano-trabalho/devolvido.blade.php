<x-mail::message>
<img src="{{ $message->embed(public_path('storage/img/logo-cnapne-sem-texto.png')) }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

# Olá, {{ $notifiable->nome }}!

O seu plano de trabalho do estudante "**{{ $planoTrabalho->nome }}**" foi devolvido para retificação.

Ele ficará marcado como devolvido até que você preencha novamente os campos necessários.

@if(array_key_exists('devolvidoObservacao', $planoTrabalho->campos))

<h1 style="margin-top: 30px">Observação adicionada na devolução:</h1>

<p style="white-space: pre-line;">{{ $planoTrabalho->campos['devolvidoObservacao'] }}</p>
@endif

<x-mail::button :url="route('planos-trabalho.show', ['planoTrabalho' => $planoTrabalho])">
Ver plano de trabalho
</x-mail::button>

**Atenção:** O SUAPNE só pode ser acessado em um computador ligado à rede do IFPR Campus Curitiba.

</x-mail::message>
