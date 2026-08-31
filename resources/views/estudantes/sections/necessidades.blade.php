@props(['estudante'])

<x-secao-expansivel title="Necessidades" class="mt-5">
    <p class="p-5 whitespace-pre-line">{{ $estudante->necessidades }}</p>
</x-secao-expansivel>
