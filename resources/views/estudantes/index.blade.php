<x-layouts.main title="Estudantes">
    @php
        if (App\Models\Estudante::count() === 0) {
            App\Models\Estudante::factory()->count(20)->create();
        }
        $items = App\Models\Estudante::paginate(10);
    @endphp

    <x-list-view title="Estudantes registrados" :items="$items" :columns="[
        ['label' => 'Nome do estudante', 'key' => 'nome', 'size' => 'large'],
        ['label' => 'Curso do estudante', 'key' => 'curso', 'size' => 'large'],
        ['label' => 'Período', 'key' => 'periodo', 'size' => 'small', 'format' => fn($value) => $value . 'º'],
        ['label' => 'Situação', 'key' => 'situacao', 'size' => 'small', 'format' => fn($value) => view('components.status', ['label' => $value, 'color' => 'dark'])->render()],
    ]" create-label="Cadastrar novo" create-url="{{ route('estudantes.form') }}"
        icon="{{ asset('storage/img/placeholder-user.png') }}" :image-icon="true" :actions="[['url' => '/', 'method' => 'POST']]" empty-message="Nenhum estudante encontrado" :filters="[
        'visible' => [
            ['label' => 'Nome do estudante', 'key' => 'nome', 'type' => 'text', 'filter' => fn($key, $value) => $key->contains($value)],
            ['label' => 'Curso do estudante', 'key' => 'curso', 'type' => 'text', 'filter' => fn($key, $value) => $key->contains($value)],
            ['label' => 'Período', 'key' => 'periodo', 'type' => 'number', 'filter' => fn($key, $value) => $key->contains($value)],
            ['label' => 'Situação', 'key' => 'situacao', 'type' => 'select', 'options' => ['Matriculado', 'Formado', 'Evadido'], 'filter' => fn($key, $value) => $key->contains($value)],
        ]
    ]" />
</x-layouts.main>