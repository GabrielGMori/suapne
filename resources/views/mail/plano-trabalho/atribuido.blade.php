<x-mail::message>

# Olá, {{ $notifiable->nome }}!

@if ($planosTrabalho->count() === 1)
Um novo plano de trabalho do estudante (PTE) foi atribuído a você:
@else
{{ $planosTrabalho->count() }} novos planos de trabalho do estudante (PTE) foram atribuídos a você:
@endif

<div style="margin: 40px 0px">

@foreach ($planosTrabalho as $plano)
- <a href="{{ route('planos-trabalho.show', ['planoTrabalho' => $plano]) }}">{{ $plano->nome }}</a>
@endforeach

</div>

@if ($planosTrabalho->count() > 1)
Eles ficarão marcados como pendentes até que você preencha os campos necessários.
@else
Ele ficará marcado como pendente até que você preencha os campos necessários.
@endif

<x-mail::button :url="route('planos-trabalho.index', ['filter' => ['status' => ['PENDENTE']]])">
Ver planos de trabalho pendentes
</x-mail::button>

Atenção: O sistema SUAPNE só pode ser acessado em um computador ligado à rede do IFPR Campus Curitiba.

</x-mail::message>
