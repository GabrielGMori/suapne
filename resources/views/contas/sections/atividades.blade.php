@props(['user'])

@php
    use App\Support\ModelLabels;
    use OwenIt\Auditing\Models\Audit;

    $acoes = Audit::query()->where('user_id', $user->id)->latest()->take(10)->get();
@endphp

<x-secao-expansivel title="Minhas Últimas Ações" class="mt-5">
    <div class="p-5 flex flex-col gap-2">
        @if ($acoes->isEmpty())
            <p>Nenhuma ação foi registrada em sua conta no momento</p>
        @else
            @foreach ($acoes as $acao)
                @php
                    $nome = $acao->auditable?->nome ?? ($acao->old_values['nome'] ?? ModelLabels::label($acao->auditable_type));
                    $verbo = match ($acao->event) {
                        'created' => 'Criou',
                        'deleted' => 'Excluiu',
                        'restored' => 'Restaurou',
                        'updated' => 'Editou',
                        default => 'Alterou',
                    };
                    $descricao = $verbo . ' ' . $nome;
                @endphp

                <x-documento name="{{ $descricao }}" icon="history">
                    <p>{{ ModelLabels::label($acao->auditable_type) }}</p>
                    <span
                        class="text-secondary-accent whitespace-nowrap">{{ $acao->created_at->diffForHumans() }}</span>
                </x-documento>
            @endforeach

            @can('viewAny', Audit::class)
                <x-button class="mt-2 self-center" label="Ver registro completo" height="small" color="tertiary"
                    type="link" href="{{ route('registro-auditoria.index') }}" />
            @endcan
        @endif
    </div>
</x-secao-expansivel>
