@props(['disciplina' => null])

<x-layouts.main title="{{ $disciplina === null ? 'Cadastrar disciplina' : 'Editar disciplina' }}">

    <form action="{{ $disciplina === null ? route('disciplinas.store') : route('disciplinas.update', $disciplina) }}"
        method="POST">
        @csrf

        @if($disciplina !== null)
            @method('PUT')
        @endif

        <div class="space-y-4">

            <h2 class="text-xl font-semibold">
                Informações da disciplina
            </h2>

            <div>
                <livewire:form.input label="Nome do componente curricular" name="nome" appearance="outlined"
                    :value="$disciplina?->nome" required />
            </div>

            <div>
                <livewire:form.select label="Curso*" appearance="outlined" size="large" name="curso_id"
                    :options="\App\Models\Curso::pluck('nome', 'id')->toArray()" :value="$disciplina?->curso_id"
                    required />
            </div>

            <div>
                <livewire:form.input type="textarea" label="Ementa" name="ementa" appearance="outlined" size="full"
                    class="resize-none" :value="$disciplina?->ementa" />
            </div>

            <div class="flex justify-end gap-2">

                <x-button label="Cancelar" type="link"
                    href="{{ url()->previous() !== url()->current() ? url()->previous() : route('disciplinas.index') }}"
                    color="red" />

                <x-button label="{{ $disciplina === null ? 'Registrar' : 'Atualizar' }}" type="submit" />

            </div>

        </div>
    </form>

</x-layouts.main>
```