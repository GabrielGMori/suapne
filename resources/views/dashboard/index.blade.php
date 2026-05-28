<x-layouts.main title="Olá, seja bem-vindo(a)!">
    <div class="grid grid-cols-2 gap-8 w-full">
        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-4">
                @php($solicitacoes = \App\Models\SolicitacaoRegistro::count())
                @if($solicitacoes === 0)
                    <x-icon icon="check" class="text-primary-accent" size="50" label="Não há solicitações de cadastro no momento" />
                @else
                    <x-icon icon="person_alert" size="60" class="ml-1" label="Existem {{$solicitacoes}} solicitaç{{$solicitacoes === 1 ? 'ão' : 'ões'}} de cadastro aguardando aprovação" />
                    <x-button label="Ver solicitações" color="tertiary" />
                @endif
            </div>
        </div>

        <div class="col-span-2 space-y-1">
            <div class="flex items-center gap-4">
                @php($planos = \App\Models\PlanoTrabalhoEstudante::where('status', \App\Enums\StatusPlanoTrabalhoEnum::Pendente->value)->count())
                @if($planos === 0)
                    <x-icon icon="check" class="text-primary-accent" size="50" label="Não há PTEs aguardando revisão no momento" />
                @else
                    <x-icon icon="notification_important" size="60" label="Existem {{$planos}} PTE{{$planos === 1 ? '' : 's'}} aguardando revisão" />
                    <x-button label="Ver solicitações" color="tertiary" />
                @endif
            </div>

            <hr class="text-on-surface my-5">
        </div>

        <div class="space-y-5 col-span-2 xl:col-span-1">
            <x-icon icon="article_person" size="50" label="Iniciar atendimento semanal" />

            <div class="flex items-end gap-4 mb-15">
                <div class="w-full max-w-sm">
                    <livewire:form.input label="Estudante" appearance="outlined" size="full" disabled />
                </div>
                <x-button label="Iniciar atendimento" />
            </div>

            <x-icon icon="assignment_add" size="50" label="Criar plano de trabalho do estudante" />

            <div class="flex items-end gap-4">
                <div class="w-full max-w-sm">
                    <livewire:form.input label="Estudante" appearance="outlined" size="full" disabled />
                </div>
                <x-button label="Criar PTE" />
            </div>
        </div>

        <div class="space-y-10 row-span-2 col-span-2 xl:col-span-1">
            <h3>Últimas alterações</h3>
            @php($acoes = \App\Models\RegistroAcao::count())
            <div class="bg-surface rounded-lg flex flex-col items-center h-100 p-5">
                @if($acoes === 0)
                    <p class="grow flex items-center">Nenhuma ação encontrada</p>
                @else
                    @foreach(\App\Models\RegistroAcao::take(5)->get() as $acao)

                    @endforeach
                    <x-button label="Ver mais" />
                @endif
            </div>
        </div>
    </div>
</x-layouts.main>
