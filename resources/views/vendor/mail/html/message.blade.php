@props(['logo'])
<x-mail::layout>

{{-- Body --}}
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
