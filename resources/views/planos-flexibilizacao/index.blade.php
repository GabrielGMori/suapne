<x-layouts.main title="Planos de Flexibilização Curricular">
    <div class="flex flex-col gap-3 mt-10">
        @php($count = \App\Models\Estudante::doesntHave('planosFlexibilizacaoCurricular')->count())
        @if($count > 0)
            <x-icon icon="notification_important" size="45" label="Existem {{$count}} estudante{{$count === 1 ? '' : 's'}} sem plano de flexibilização para este ano" />
            <x-button type="link" href="{{route('planos-flexibilizacao.create')}}" color="tertiary" icon="add" label="Criar Plano"/>
        @else
            <x-icon icon="check" class="text-primary-accent" size="45" label="Todos os estudantes registrados possuem um plano de flexibilização para este ano" />
        @endif
    </div>
    <hr class="my-10 text-on-surface">
    <livewire:list-view :config="App\Tables\PlanoFlexibilizacaoCurricularTable::class"/>
</x-layouts.main>
