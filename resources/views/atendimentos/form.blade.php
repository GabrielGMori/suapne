@props(['atendimento'=>null])

<?php
    use App\Models\Estudante;
?>

<x-layouts.main title="Registrar Atendimento semanal">
    <form action="{{ route('atendimentos.store') }}" method="POST">
    @csrf
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Dados do estudante</h2>
         <livewire:form.select label="Estudante" name="estudante_id" appearance="outlined" placeholder="Selecionar" :options="Estudante::pluck('nome','id')->toArray()" :value="$atendimento?->estudante_id"/>
         <livewire:form.input type="text" label="Local" appearance="outlined" size="small" name="local" :value="$atendimento?->local"/>
         <livewire:form.input type="datetime" label="Dia" appearance="outlined" name="data" :value="$atendimento?->data->format('Y-m-d H:i:s')"/>
         <livewire:form.input type="textarea" label="Perfil do Estudante" appearance="outlined" name="campos[perfilDoEstudante]" size="full" value="{{old('campos.perfilDoEstudante')}}"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Registro do Atendimento</h2>
        <livewire:form.input type="textarea" name="campos[registroDoAtendimento]" appearance="outlined" size="full" value="{{old('campos.registroDoAtendimento')}}"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Encaminhamentos</h2>
        <livewire:form.input type="textarea" name="campos[encaminhamentos]" appearance="outlined" size="full" value="{{old('campos.encaminhamentos')}}"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Observações adicionais</h2>
        <livewire:form.input type="textarea" name="campos[observacoesAdicionais]" appearance="outlined" size="full" value="{{old('campos.observacoesAdicionais')}}"/>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('atendimentos.index') }}" color="red"/>
        <x-button type="submit" label="Registrar"/>
    </div>
    @if($errors)
        @foreach($errors as $error)
            dd($error)
        @endforeach
    @endif
</x-layouts.main>
