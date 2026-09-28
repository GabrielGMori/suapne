@props([
    'registro',
    'secao' => '',
    'etapa' => '',
    'ordemMin' => 0,
    'ordemMax' => null,
    'vazio' => '---',
])

@php
    use Illuminate\Support\Carbon;

    $itens = $registro->camposAdicionaisAgrupados($secao, $etapa, $ordemMin, $ordemMax);

    $formatar = function (array $campo) use ($registro) {
        $valor = $registro->valorCampo($campo['chave']);

        if (filled($valor) && ($campo['tipo'] ?? '') === 'date') {
            return Carbon::parse($valor)->format('d/m/Y');
        }

        return is_array($valor) ? implode(', ', $valor) : $valor;
    };
@endphp

@foreach ($itens as $item)
    @if (isset($item['grupo']))
        @php $grupoCampos = array_filter($item['campos'], fn($c) => $c['tipo'] !== 'especial'); @endphp
        @if (count($grupoCampos))
            <table class="table">
                <tr><td><b>{{ $item['titulo'] }}</b></td></tr>
                @foreach ($grupoCampos as $campo)
                    @php $valor = $formatar($campo); @endphp
                    <tr><td>{{ $campo['rotulo'] }}: <b>{{ filled($valor) ? $valor : $vazio }}</b></td></tr>
                @endforeach
            </table>
        @endif
    @elseif ($item['campo']['tipo'] !== 'especial')
        @php $campo = $item['campo']; $valor = $formatar($campo); @endphp
        <table class="table">
            <tr>
                <td>
                    <b>{{ rtrim($campo['rotulo'], ':') }}</b>
                    @if (!empty($campo['descricao']))
                        <br>{{ $campo['descricao'] }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="textarea">{{ filled($valor) ? $valor : $vazio }}</td>
            </tr>
        </table>
    @endif
@endforeach
