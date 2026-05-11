@props(['role' => 'docente_especial'])

@php
    $navItems = [
        ['label' => 'Início', 'href' => '#', 'icon' => 'home'],
        ['label' => 'Estudantes', 'href' => '#', 'icon' => 'school'],
    ];

    if ($role === 'professor_regular') {
        $navItems = [...$navItems, ['label' => 'Planos de trabalho', 'href' => '#', 'icon' => 'assignment']];
    }

    if ($role === 'tecnico') {
        $navItems = [...$navItems, ['label' => 'Registro de auditoria', 'href' => '#', 'icon' => 'history']];
    }

    if ($role === 'docente_especial') {
        $navItems = [
            ...$navItems,
            ['label' => 'Planos de flexibilização', 'href' => '#', 'icon' => 'tune'],
            ['label' => 'Planos de trabalho', 'href' => '#', 'icon' => 'assignment'],
            ['label' => 'Atendimentos', 'href' => '#', 'icon' => 'article_person'],
            ['divider' => true],
            ['label' => 'Registro de auditoria', 'href' => '#', 'icon' => 'history'],
            ['label' => 'Contas da CNAPNE', 'href' => '#', 'icon' => 'server_person'],
            ['label' => 'Contas de professores', 'href' => '#', 'icon' => 'person'],
            ['label' => 'Solicitações de registro', 'href' => '#', 'icon' => 'pending_actions'],
            ['divider' => true],
            ['label' => 'Cursos', 'href' => '#', 'icon' => 'backpack'],
            ['label' => 'Disciplinas', 'href' => '#', 'icon' => 'book'],
        ];
    }
@endphp

<aside
    x-data="{
        collapsed: window.matchMedia('(max-width: 1200px)').matches,
        compact: window.matchMedia('(max-width: 1200px)').matches,
        collapseTimer: null,
        toggleMenu() {
            clearTimeout(this.collapseTimer);

            if (this.collapsed) {
                this.compact = false;
                this.collapsed = false;
                return;
            }

            this.collapsed = true;
            this.collapseTimer = setTimeout(() => this.compact = true, 300);
        },
    }"
    data-expanded="true"
    :data-expanded="!collapsed ? 'true' : 'false'"
    data-compact="false"
    :data-compact="compact ? 'true' : 'false'"
    class="group/sidebar w-64 px-3 data-[expanded=false]:w-14 data-[expanded=false]:px-2 bg-secondary-container text-white sticky top-0 self-start h-screen flex flex-col overflow-hidden shrink-0 transition-[width,padding] duration-300 ease-in-out">

    <a href="#"
       class="h-[100px] group-data-[expanded=false]/sidebar:h-[72px] flex items-center justify-center py-3 transition-[height] duration-300">
        <div class="w-full group-data-[expanded=false]/sidebar:w-10 relative flex items-center justify-center h-16 transition-[width] duration-300 ease-in-out">
            <img class="opacity-100 scale-100 group-data-[expanded=false]/sidebar:opacity-0 group-data-[expanded=false]/sidebar:scale-75 group-data-[expanded=false]/sidebar:pointer-events-none absolute h-16 max-w-none shrink-0 transition-all duration-300 object-contain"
                src="{{ asset('storage/img/logo-cnapne.png') }}" alt="CNAPNE">
            <img class="opacity-0 scale-75 pointer-events-none group-data-[expanded=false]/sidebar:opacity-100 group-data-[expanded=false]/sidebar:scale-100 group-data-[expanded=false]/sidebar:pointer-events-auto absolute h-10 w-10 shrink-0 transition-all duration-300 object-contain"
                src="{{ asset('storage/img/logo-cnapne-sem-texto.png') }}" alt="CNAPNE">
        </div>
    </a>

    <div class="flex justify-center py-2">
        <a href="#"
            class="w-full justify-start gap-3 pr-3 bg-secondary hover:bg-white/5 group-data-[expanded=false]/sidebar:w-10 group-data-[expanded=false]/sidebar:aspect-square group-data-[expanded=false]/sidebar:justify-start group-data-[expanded=false]/sidebar:p-0 group-data-[expanded=false]/sidebar:bg-transparent group-data-[expanded=false]/sidebar:hover:bg-transparent flex items-center h-10 overflow-hidden rounded-full transition-[width,padding,background-color] duration-300 ease-in-out text-white"
            title="{{ $user ?? 'Minha conta' }}">
            <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário"
                class="h-10 w-10 object-cover rounded-full shrink-0">
            <span x-show="!collapsed" class="text-label-medium truncate">{{ $user ?? 'Minha conta' }}</span>
        </a>
    </div>

    <div class="my-2 mx-1 border-t border-white/10"></div>

    <nav class="flex flex-1 flex-col items-stretch overflow-y-auto overflow-x-hidden py-2 custom-scrollbar">
        @foreach ($navItems as $item)
            @if (isset($item['divider']) && $item['divider'])
                <div class="my-2 mx-1 border-t border-white/10"></div>
            @else
                <a href="{{ $item['href'] ?? '#' }}" draggable="false"
                    title="{{ $item['label'] }}"
                    class="w-full justify-start px-2 group-data-[expanded=false]/sidebar:px-[10px] group-data-[compact=true]/sidebar:!w-10 group-data-[compact=true]/sidebar:!aspect-square group-data-[compact=true]/sidebar:!justify-center group-data-[compact=true]/sidebar:!px-0 group-data-[compact=true]/sidebar:!mx-auto flex items-center h-10 gap-3 overflow-hidden rounded-lg text-label-small text-on-surface hover:bg-white/5 hover:text-white transition-[width,padding,color,background-color] duration-300 ease-in-out group whitespace-nowrap">
                    @if (isset($item['icon']))
                        <span class="material-symbols-outlined text-[20px] text-primary group-hover:text-primary-accent shrink-0">
                            {{ $item['icon'] }}
                        </span>
                    @endif
                    <span x-show="!collapsed" class="truncate">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endif
        @endforeach

        <div class="my-2 mx-1 border-t border-white/10"></div>

        <a href="#" draggable="false"
            :title="collapsed ? 'Sair' : ''"
            class="w-full justify-start px-2 group-data-[expanded=false]/sidebar:px-[10px] group-data-[compact=true]/sidebar:!w-10 group-data-[compact=true]/sidebar:!aspect-square group-data-[compact=true]/sidebar:!justify-center group-data-[compact=true]/sidebar:!px-0 group-data-[compact=true]/sidebar:!mx-auto flex items-center h-10 gap-3 overflow-hidden rounded-lg text-label-small text-on-surface hover:bg-white/5 hover:text-white transition-[width,padding,color,background-color] duration-300 ease-in-out group whitespace-nowrap">
            <span class="material-symbols-outlined text-[20px] text-red group-hover:text-error shrink-0">logout</span>
            <span x-show="!collapsed" class="truncate">Sair</span>
        </a>
    </nav>

    <div class="mt-auto flex justify-center py-2">
        <button @click="toggleMenu()"
            class="w-full justify-start px-2 group-data-[expanded=false]/sidebar:px-[10px] group-data-[compact=true]/sidebar:!w-10 group-data-[compact=true]/sidebar:!aspect-square group-data-[compact=true]/sidebar:!justify-center group-data-[compact=true]/sidebar:!px-0 cursor-pointer flex items-center h-10 gap-3 rounded-lg text-white hover:bg-white/5 transition-[width,padding,background-color] duration-300 ease-in-out overflow-hidden whitespace-nowrap">
            <span class="material-symbols-outlined text-[20px] shrink-0"
                  x-text="collapsed ? 'keyboard_double_arrow_right' : 'keyboard_double_arrow_left'">
            </span>
            <span x-show="!collapsed" class="text-label-small truncate">
                Recolher menu
            </span>
        </button>
    </div>
</aside>
