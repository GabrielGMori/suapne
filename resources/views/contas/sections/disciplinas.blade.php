@props(['user'])

@if ($user->role === App\Enums\RoleEnum::PROFESSOR_REGULAR)
    <x-secao-expansivel title="Minhas Disciplinas" class="mt-5">
        <div class="p-5 flex flex-col gap-4">
            @if (count($user->disciplinas) > 0)
                <div class="flex flex-col gap-2">
                    @foreach ($user->disciplinas as $disciplina)
                        <x-documento name="{{ $disciplina->nome }}" icon="book">
                            <p>Curso: {{ $disciplina->curso->nome }}</p>
                            <p>Período: {{ $disciplina->curso_periodo }}</p>
                        </x-documento>
                    @endforeach
                </div>
            @else
                <p>Nenhuma disciplina está vinculada à sua conta no momento</p>
            @endif
        </div>
    </x-secao-expansivel>
@endif
