<x-layouts.main title="Início" header="Olá, {{Auth::user()->nome}}!">
    <div class="grid grid-cols-2 gap-8 w-full mt-8">
        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-1">
                @php($solicitacoes = \App\Models\SolicitacaoRegistro::count())
                @if($solicitacoes === 0)
                    <x-icon icon="check" class="text-primary-accent" size="45"
                        label="Não há solicitações de cadastro no momento" />
                @else
                    <x-icon icon="person_alert" class="ml-1" size="45"
                        label="Existem {{$solicitacoes}} solicitaç{{$solicitacoes === 1 ? 'ão' : 'ões'}} de cadastro aguardando aprovação" />
                    <x-button icon="open_in_new" size="dynamic" color="transparent" type="link"
                        href="{{route('solicitacoes-registro.index')}}" />
                @endif
            </div>
        </div>

        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-1">
                @php($planos = \App\Models\PlanoTrabalhoEstudante::where('status', \App\Enums\StatusPlanoTrabalhoEnum::PENDENTE)->count())
                @if($planos === 0)
                    <x-icon icon="check" class="text-primary-accent" size="45"
                        label="Não há PTEs aguardando revisão no momento" />
                @else
                    <x-icon icon="notification_important" size="45"
                        label="Existem {{$planos}} PTE{{$planos === 1 ? '' : 's'}} aguardando revisão" />
                    <x-button icon="open_in_new" size="dynamic" color="transparent" type="link"
                        href="{{route('planos-trabalho.index')}}" />
                @endif
            </div>

            <hr class="text-on-surface my-5">
        </div>

        <livewire:stateful-forms.estudante-quick-start />

        <div class="space-y-2 row-span-2 col-span-2 xl:col-span-1">
            <h3>Últimas alterações</h3>
            @php($acoes = OwenIt\Auditing\Models\Audit::query()->latest()->take(5)->get())
            <div class="bg-surface rounded-xl flex flex-col items-center h-max p-5 gap-1">
                @if($acoes->isEmpty())
                    <p class="grow flex items-center">Nenhuma ação encontrada</p>
                @else
                    @foreach($acoes as $registroAcao)
                        <div class="bg-on-surface rounded-lg flex items-center gap-2 justify-stretch w-full p-2">
                            <img src="{{ asset($registroAcao->user?->avatar ?? 'storage/img/placeholder-user.png') }}"
                                alt="{{ $registroAcao->user?->nome ?? 'Usuário' }}"
                                class="h-15 w-15 object-cover rounded-full shrink-0" />

                            <p>
                                <b>{{ $registroAcao->user?->nome ?? 'Usuário' }}</b>
                                {{ strtolower($registroAcao->acao) }}

                                @if($registroAcao->event === 'update')
                                    de
                                @endif

                                <b>{{ $registroAcao->estudante?->nome ?? 'estudante removido' }}</b>
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
    </div>
</x-layouts.main>
