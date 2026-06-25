<x-layouts.main title="Início" header="Olá, {{auth()->user()->nome}}!">
    <div class="grid grid-cols-2 gap-8 w-full mt-8">
        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-1">
                @php($solicitacoes = \App\Models\SolicitacaoRegistro::count())
                @if($solicitacoes === 0)
                    <x-icon icon="check" class="text-primary-accent" size="45" label="Não há solicitações de cadastro no momento" />
                @else
                    <x-icon icon="person_alert" class="ml-1" size="45" label="Existem {{$solicitacoes}} solicitaç{{$solicitacoes === 1 ? 'ão' : 'ões'}} de cadastro aguardando aprovação" />
                    <x-button icon="open_in_new" size="dynamic" color="transparent" type="link" href="{{route('solicitacoes-registro.index')}}" />
                @endif
            </div>
        </div>

        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-1">
                @php($planos = \App\Models\PlanoTrabalhoEstudante::where('status', \App\Enums\StatusPlanoTrabalhoEnum::PENDENTE)->count())
                @if($planos === 0)
                    <x-icon icon="check" class="text-primary-accent" size="45" label="Não há PTEs aguardando revisão no momento" />
                @else
                    <x-icon icon="notification_important" size="45" label="Existem {{$planos}} PTE{{$planos === 1 ? '' : 's'}} aguardando revisão" />
                    <x-button icon="open_in_new" size="dynamic" color="transparent" type="link" href="{{route('planos-trabalho.index')}}" />
                @endif
            </div>

            <hr class="text-on-surface my-5">
        </div>

        <div class="space-y-5 col-span-2 xl:col-span-1">
            <x-icon icon="article_person" size="40" label="Iniciar atendimento semanal" />

            <div class="flex items-end gap-4 mb-15">
                <div class="w-full max-w-sm">
                    <livewire:form.input label="Estudante" appearance="outlined" size="full" disabled />
                </div>
                <x-button label="Iniciar atendimento" type="link" href="{{route('atendimentos.form')}}" />
            </div>

            <x-icon icon="assignment_add" size="40" label="Criar plano de trabalho do estudante" />

            <div class="flex items-end gap-4">
                <div class="w-full max-w-sm">
                    <livewire:form.input label="Estudante" appearance="outlined" size="full" disabled />
                </div>
                <x-button label="Criar PTE" type="link" href="{{route('planos-trabalho.form')}}" />
            </div>
        </div>

        <div class="space-y-2 row-span-2 col-span-2 xl:col-span-1">
            <h3>Últimas alterações</h3>
            @php($acoes = \App\Models\RegistroAcao::count())
            <div class="bg-surface rounded-xl flex flex-col items-center h-max p-5 gap-1">
                @if($acoes === 0)
                    <p class="grow flex items-center">Nenhuma ação encontrada</p>
                @else
                    @foreach(\App\Models\RegistroAcao::take(5)->get() as $registroAcao)
                        <div class="bg-on-surface rounded-lg flex items-center gap-2 justify-stretch w-full p-2">
                            <img src="{{asset($registroAcao->user->avatar)}}" alt="{{$registroAcao->user->nome}}" class="h-15 rounded-full" />
                            <p><b>{{$registroAcao->user->nome}}</b> {{strtolower($registroAcao->acao)}}
                                {{$registroAcao->tipo === \App\Enums\TipoRegistroAcaoEnum::EDICAO_ESTUDANTE ? 'de' : ''}} <b>{{$registroAcao->estudante->nome}}</b></p>
                            <div class="flex justify-end grow"><x-button icon="open_in_new" color="transparent" type="link" href="{{route('registro-auditoria.index')}}" /></div>
                        </div>
                    @endforeach
                    <x-button label="Ver mais" height="small" color="tertiary" type="link" href="{{route('registro-auditoria.index')}}" />
                @endif
            </div>
        </div>
    </div>
</x-layouts.main>

