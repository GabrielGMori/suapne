@props([
    'name' => 'Documento do estudante', // Nome do documento (e.g., 'Ficha de atendimento')
    'icon' => 'draft', // Icone estilo Google Materal Icons do documento (esquerda)
    'date' => 'Data', // Data do documento
    'actionIcon' => 'open_in_new', // Icone estilo Google Materal Icons do botão de ação (direita)
    'actionUrl' => '', // URL do botão de ação
    // 'metadata' como slot para metadados do documento (e.g., 'Data', 'Autor')
    // 'extraActions' como slot para ações do documento (e.g., 'Download', 'Visualizar')
])

<article {{ $attributes->merge(['class' => 'rounded-lg bg-on-surface text-black py-2 px-3 flex items-center']) }}>
    <div class="flex gap-1 items-center">
        <x-icon size="30" icon="{{ $icon }}" />
        <p class="text-body-medium">{{ $name }}</p>
        {{ $extraActions ?? '' }}
    </div>
    <div class="grow flex gap-2 justify-end items-center">
        {{ $metadata ?? '' }}
        <x-button type="link" href="{{ $actionUrl }}" icon="{{ $actionIcon }}" color="transparent" />
    </div>

</article>
