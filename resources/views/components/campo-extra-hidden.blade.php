@props(['campo', 'snapshot' => false])

<input type="hidden" name="campos_extras[{{ $campo['chave'] }}]"
    value="{{ json_encode($snapshot ? [...$campo, 'snapshot' => true] : $campo) }}">
