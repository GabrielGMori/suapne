<?php
use App\Models\Curso;
?>

<x-layouts.main title="{{ $titulo }}">
        <form action="{{ $curso->exists ? route('cursos.update', $curso->id) : route('cursos.store') }}" method="POST">
        @if($curso->exists){
            @method('PATCH');
        }
        @endif
        @csrf
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Informações do curso</h2>
        <hr class="text-on-surface">
        <div class="grid grid-cols-2">
            <div>
                <livewire:form.input label="Nome do curso*" appearance="outlined" size="large" name="nome" required value="{{ $curso->nome ?? old('nome') }}"/>
            </div>
            <div>
                <livewire:form.input label="Quantidade de períodos*" appearance="outlined" size="large" name="quantidade_periodos" required value="{{ $curso->quantidade_periodos ?? old('quantidade_periodos') }}"/>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('cursos.index') }}" color="red"/>
        <x-button label="Registrar" type="submit"/>
    </div>
    </form>
</x-layouts.main>
