@props([
    'registro',
    'secao' => '',
    'etapa' => '',
    'ate' => '',
    'depois' => '',
    'vazio' => '---',
    'vazioObrigatorio' => null,
    'italicoVazio' => false,
])

@php
    use App\Support\CamposTemplate;
    use Illuminate\Support\Carbon;

    $itens = $registro->camposAdicionaisAgrupados($secao, $etapa, $ate, $depois);
    $numeros = $registro->numeracaoCampos();

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
            <div class="flex flex-col bg-surface rounded-lg gap-3 mb-5 p-5">
                <h2 class="text-display-small mb-2">{{ CamposTemplate::titulo($numeros[$item['campos'][0]['chave']] ?? null, $item['titulo']) }}</h2>
                @foreach ($grupoCampos as $campo)
                    @php $valor = $formatar($campo); @endphp
                    <p>{{ $campo['rotulo'] }}: <b>{{ filled($valor) ? $valor : $vazio }}</b></p>
                @endforeach
            </div>
        @endif
    @elseif ($item['campo']['tipo'] !== 'especial')
        @php
            $campo = $item['campo'];
            $valor = $formatar($campo);
            $preenchido = filled($valor);
            $textoVazio = ($campo['obrigatorio'] ?? false) && $vazioObrigatorio !== null ? $vazioObrigatorio : $vazio;
        @endphp
        <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
            <h2 class="text-display-small">{{ CamposTemplate::titulo($numeros[$campo['chave']] ?? null, $campo['rotulo']) }}</h2>

            @if (!empty($campo['descricao']))
                <p>{{ $campo['descricao'] }}</p>
            @endif

            <div class="flex flex-col bg-surface border border-on-surface rounded-lg p-5 {{ !$preenchido && $italicoVazio ? 'italic' : '' }}">
                <p class="whitespace-pre-line">{{ $preenchido ? $valor : $textoVazio }}</p>
            </div>
        </div>
    @endif
@endforeach
