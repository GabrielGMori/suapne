@props(['campo', 'snapshot' => false])

@if ($snapshot)
    <input type="hidden" name="campos_extras[{{ $campo['chave'] }}][snapshot]" value="1">
@endif

@foreach ($campo as $atributo => $valor)
    @if (is_array($valor))
        @foreach ($valor as $chaveOpcao => $valorOpcao)
            <input type="hidden" name="campos_extras[{{ $campo['chave'] }}][{{ $atributo }}][{{ $chaveOpcao }}]" value="{{ $valorOpcao }}">
        @endforeach
    @else
        <input type="hidden" name="campos_extras[{{ $campo['chave'] }}][{{ $atributo }}]" value="{{ is_bool($valor) ? (int) $valor : $valor }}">
    @endif
@endforeach
