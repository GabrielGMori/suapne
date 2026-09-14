@props(['user'])

@php
    use App\Models\Disciplina;

    $currDisciplinas = $user->disciplinas->map(fn($disc)=>$disc->id)->toArray();
    $disciplinas = Disciplina::with('curso')->get()->mapWithKeys(fn($disc)=>[$disc->id => $disc->nome." - ".$disc->curso])->toArray();
@endphp

<x-layouts.main title="Editar conta de professor">
    <form action="{{ route('contas.professor.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
            <h2 class="text-display-small">Dados do professor</h2>
            <hr class="text-on-surface mb-10" />

            <div class="grid grid-cols-3 ml-15">
                <livewire:avatar-upload :default-img-path="old('avatar', $user?->avatar)" class="row-span-3" />
                <x-form.input name="nome" label="Nome" appearance="outlined" :value="$user->name"
                    size="large" />
                <x-form.input type="email" name="email" label="E-mail" appearance="outlined" :value="$user->email"
                    size="large" />

                <livewire:form.select label="Disciplinas" type="multiselect" name="disciplinas" appearance="outlined" size="xlarge"
                :value="$currDisciplinas" :options="$disciplinas" />
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <x-button.cancel fallback="contas.professor.index" />
            <x-button label="Salvar alterações" type="submit" color="primary" />
        </div>
    </form>
</x-layouts.main>
