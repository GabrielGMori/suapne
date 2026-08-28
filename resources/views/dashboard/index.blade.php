@php
    use App\Enums\RoleEnum;
    use App\Enums\StatusPlanoTrabalhoEnum;
    use App\Models\PlanoTrabalhoEstudante;
    use OwenIt\Auditing\Models\Audit;

    $user = Auth::user();

    $solicitacoes = \App\Models\SolicitacaoRegistro::count();

    $planos = $user->role === RoleEnum::PROFESSOR_REGULAR
        ? $user->planosTrabalhoProfessor->where('status', StatusPlanoTrabalhoEnum::PENDENTE)->count()
        : PlanoTrabalhoEstudante::where('status', StatusPlanoTrabalhoEnum::AGUARDANDO_REVISAO)->count();
    $plural = $planos === 1 ? '' : 's';
    $isProfessorRegular = $user->role === RoleEnum::PROFESSOR_REGULAR;
    $notificationType = $isProfessorRegular ? ('pendente' . $plural) : 'aguardando revisão';
    $status = $isProfessorRegular ? 'PENDENTE' : 'AGUARDANDO_REVISAO';

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
                            label="Não há solicitações de cadastro no momento" />
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
                        :href="route('planos-trabalho.index') . '?' . http_build_query(['filter' => ['status' => [$status]]])" />
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
                    @if($acoes->isEmpty())
                        <p class="grow flex items-center">Nenhuma ação encontrada</p>
                    @else
                        @foreach($acoes as $acao)
                            {{ dump() }}
                            <div class="bg-on-surface rounded-lg flex items-center gap-2 justify-stretch w-full p-2">
                                <img src="{{ asset($acao->user?->avatar ?? 'storage/img/placeholder-user.png') }}"
                                    alt="{{ $acao->user?->nome ?? 'Usuário' }}"
                                    class="h-15 w-15 object-cover rounded-full shrink-0" />
                                <p>
                                    <b>{{ $acao->user?->nome ?? 'Usuário' }}</b>
                                    {{ strtolower($acao->acao) }}

                                    @if($acao->event === 'update')
                                        de
                                    @endif

                                    <b>{{ $acao->estudante?->nome ?? 'estudante removido' }}</b>
                                </p>

                                <div class="flex justify-end grow">
                                    <x-button icon="open_in_new" color="transparent" type="link"
                                        href="{{ route('registro-auditoria.index') }}" />
                                </div>
                            </div>
                        @endforeach

                        <x-button label="Ver mais" height="small" color="tertiary" type="link"
                            href="{{ route('registro-auditoria.index') }}" />
                    @endif
                </div>
            </div>
        @endcan
    </div>
</x-layouts.main>
