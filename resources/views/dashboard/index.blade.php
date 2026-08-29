@php
    use App\Enums\RoleEnum;
    use App\Enums\StatusPlanoTrabalhoEnum;
    use App\Models\PlanoTrabalhoEstudante;
    use OwenIt\Auditing\Models\Audit;
    use App\Support\ModelLabels;

    $user = Auth::user();

    $solicitacoes = \App\Models\SolicitacaoRegistro::count();

    $planos = $user->role === RoleEnum::PROFESSOR_REGULAR
        ? $user->planosTrabalhoProfessor->filter(fn($plano) => $plano->status === StatusPlanoTrabalhoEnum::PENDENTE || $plano->status === StatusPlanoTrabalhoEnum::DEVOLVIDO)->count()
        : PlanoTrabalhoEstudante::where('status', StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)->count();
    $plural = $planos === 1 ? '' : 's';
    $isProfessorRegular = $user->role === RoleEnum::PROFESSOR_REGULAR;
    $notificationType = $isProfessorRegular ? ('pendente' . $plural) : 'aguardando revisão';
    $status = $isProfessorRegular ? ['PENDENTE', 'DEVOLVIDO'] : ['AGUARDANDO_REVISAO'];

    $acoes = Audit::query()->latest()->take(5)->get()
@endphp

<x-layouts.main title="Início" header="Olá, {{$user->nome}}!">
    <div class="grid grid-cols-2 gap-8 w-full mt-8">
        @can('viewAny', App\Models\SolicitacaoRegistro::class)
            <div class="col-span-2 space-y-1">
                <div class="flex items-center gap-1">
                    @if($solicitacoes > 0)
                        <x-icon icon="person_alert" class="ml-1" size="45"
                            label="Existe{{$solicitacoes === 1 ? '' : 'm'}} {{$solicitacoes}} solicitaç{{$solicitacoes === 1 ? 'ão' : 'ões'}} de cadastro aguardando aprovação" />
                        <x-button icon="open_in_new" size="dynamic" color="transparent" type="link"
                            href="{{route('solicitacoes-registro.index')}}" />
                    @else
                        <x-icon icon="check" class="text-primary-accent" size="45"
                            label="Não há solicitações de registro no momento" />
                    @endif
                </div>
            </div>
        @endcan

        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-1">
                @if($planos > 0)
                    <x-icon icon="notification_important" size="45"
                        label="Existe{{$planos === 1 ? '' : 'm'}} {{$planos}} PTE{{$plural}} {{ $notificationType }}" />
                    <x-button icon="open_in_new" size="dynamic" color="transparent" type="link"
                        :href="route('planos-trabalho.index') . '?' . http_build_query(['filter' => ['status' => $status]])" />
                @else
                    <x-icon icon="check" class="text-primary-accent" size="45"
                        label="Não há PTEs {{ $notificationType }} no momento" />
                @endif
            </div>

            @if(!$isProfessorRegular)
                <hr class="text-on-surface my-5">
            @endif
        </div>

        <livewire:stateful-forms.estudante-quick-start />

        @can('viewAny', Audit::class)
            <div class="space-y-2 row-span-2 col-span-2 xl:col-span-1">
                <h3>Últimas alterações</h3>
                <div class="bg-surface rounded-xl flex flex-col items-center h-max p-5 gap-1">
                    @if ($acoes->isEmpty())
                        <p class="grow flex items-center">Nenhuma ação encontrada</p>
                    @else
                        @foreach ($acoes as $acao)
                            @php
                                $autor = $acao->user?->nome ?? 'Alguém';
                                $nome = $acao->auditable?->nome ?? ($acao->old_values['nome'] ?? '');
                                $verbo = match ($acao->event) {
                                    'created' => 'criou',
                                    'deleted' => 'excluiu',
                                    'restored' => 'restaurou',
                                    'updated' => 'editou',
                                    default => 'alterou',
                                };
                            @endphp

                            <div class="flex items-center gap-4 w-full bg-on-surface p-2 rounded-xl">
                                <img src="{{ $acao->user?->avatar ? asset($acao->user->avatar) : asset('storage/img/placeholder-user.png') }}"
                                    alt="{{ $autor }}" class="h-16 w-16 object-cover rounded-full shrink-0">
                                <p class="grow text-body-medium truncate">{{ "{$autor} {$verbo} {$nome}" }}</p>
                                <span class="text-body-medium text-secondary-accent whitespace-nowrap shrink-0">{{ $acao->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach

                        <x-button class="mt-2" label="Ver mais" height="small" color="tertiary" type="link" href="{{ route('registro-auditoria.index') }}" />
                    @endif
                </div>
            </div>
        @endcan
    </div>
</x-layouts.main>
