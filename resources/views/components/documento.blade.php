@props([
    'name' => 'Documento do estudante', // Nome do documento (e.g., 'Ficha de atendimento')
    'icon' => 'draft', // Icone estilo Google Materal Icons do documento (esquerda)
    // 'slot' como slot para metadados do documento (e.g., 'Data', 'Autor')
    // 'leftSlot' como slot para ações do documento (e.g., 'Download', 'Visualizar')
])

<article {{ $attributes->merge(['class' => 'rounded-lg bg-on-surface text-black py-2 px-3 flex items-center']) }}>
    <div class="flex gap-2 items-center">
        <x-icon size="30" icon="{{ $icon }}" class="py-2" />
        <p class="text-body-medium">{{ $name }}</p>
        {{ $leftSlot ?? '' }}
    </div>
    <div class="grow flex gap-3 justify-end items-center">
        {{ $slot }}
    </div>

</article>
