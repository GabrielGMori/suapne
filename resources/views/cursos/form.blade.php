@props(['curso' =>null])

<?php
use App\Models\Curso;
?>

<x-layouts.main title="{{ $curso == null ? 'Cadastrar curso' : 'Editar curso'}}">
        <form action="{{ $curso == null ? route('cursos.store') : route('cursos.update',['curso'=>$curso])}}" method="POST">
        @if($curso !== null)
            @method('PATCH')
        @endif
        @csrf
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Informações do curso</h2>
        <hr class="text-on-surface">
        <div class="grid grid-cols-2">
            <div>
                <x-form.input label="Nome do curso*" appearance="outlined" size="large" name="nome" required :value="$curso->nome ?? null"/>
            </div>
            <div>
                <x-form.input label="Quantidade de períodos*" appearance="outlined" size="large" name="quantidade_periodos" required :value="$curso->quantidade_periodos ?? null"/>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Cancelar" type="link" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('cursos.index') }}" color="red"/>
        <x-button label="Registrar" type="submit"/>
    </div>
    </form>
</x-layouts.main>
