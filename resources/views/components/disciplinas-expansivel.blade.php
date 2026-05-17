@props([
    'disciplinas' => [],
    'expanded' => false
])

<x-secao-expansivel.bottom title="Disciplinas Associadas" :expanded="$expanded">
    @if(empty($disciplinas))
        <div class="text-secondary text-center py-4">
            Nenhuma disciplina associada a este usuário.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($disciplinas as $disciplina)
                <div class="p-4 border border-secondary-accent/20 rounded-lg bg-on-surface/5 flex justify-between items-center">
                    <div>
                        <div class="font-medium text-black">{{ $disciplina['nome'] ?? 'Disciplina' }}</div>
                        <div class="text-label-small text-secondary mt-1">{{ $disciplina['codigo'] ?? 'Sem código' }}</div>
                    </div>
                    <div>
                        <span class="px-2 py-1 bg-primary/10 text-primary text-label-small rounded-md font-medium">
                            {{ $disciplina['carga_horaria'] ?? '0h' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-secao-expansivel.bottom>
