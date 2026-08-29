<x-mail::layout>
{{-- Header --}}

{{-- Body --}}
<img src="{{ asset('storage/img/logo-cnapne-sem-texto.png') }}" alt="CNAPNE" style="height: 70px; width: auto; vertical-align: middle; margin-bottom: 20px;">

{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
{{ date('Y') }}

O Sistema Unificado para Atendimento à Pessoas com Necessidades Específicas (SUAPNE) foi desenvolvido como projeto de TCC de Informática no IFPR Campus Curitiba.
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
