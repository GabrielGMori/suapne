@props([
    'user', // Usuário logado
])

@php
    use App\Enums\RoleEnum;

    $divider = ['divider' => true];
    $sidebarStorageKey = 'cnapne.sidebar.collapsed';

    $navItems = [
        ['label' => 'Início', 'href' => route('dashboard.index'), 'icon' => 'home'],
        ['label' => 'Estudantes', 'href' => route('estudantes.index'), 'icon' => 'school'],
    ];

    if ($user->role === RoleEnum::PROFESSOR_REGULAR) {
        $navItems = [...$navItems, ['label' => 'Planos de trabalho', 'href' => route('planos-trabalho.index'), 'icon' => 'assignment']];
    }

    if ($user->role === RoleEnum::TECNICO) {
        $navItems = [...$navItems, ['label' => 'Registro de auditoria', 'href' => route('registro-auditoria.index'), 'icon' => 'history']];
    }

    if ($user->role === RoleEnum::DOCENTE_ESPECIAL) {
        $navItems = [
            ...$navItems,
            ['label' => 'Planos de flexibilização', 'href' => route('planos-flexibilizacao.index'), 'icon' => 'tune'],
            ['label' => 'Planos de trabalho', 'href' => route('planos-trabalho.index'), 'icon' => 'assignment'],
            ['label' => 'Atendimentos', 'href' => route('atendimentos.index'), 'icon' => 'article_person'],
            $divider,
            ['label' => 'Registro de auditoria', 'href' => route('registro-auditoria.index'), 'icon' => 'history'],
            ['label' => 'Contas da CNAPNE', 'href' => route('contas.cnapne.index'), 'icon' => 'server_person'],
            ['label' => 'Contas de professores', 'href' => route('contas.professor.index'), 'icon' => 'person'],
            ['label' => 'Solicitações de registro', 'href' => route('solicitacoes-registro.index'), 'icon' => 'pending_actions'],
            $divider,
            ['label' => 'Cursos', 'href' => route('cursos.index'), 'icon' => 'backpack'],
            ['label' => 'Disciplinas', 'href' => route('disciplinas.index'), 'icon' => 'book'],
        ];
    }

     $navItems = [...$navItems,
         $divider,
         ['label' => 'Sair', 'href' => route('logout'), 'icon' => 'logout', 'red' => true, 'method' => 'POST'],
     ];

    $dividerClasses = 'my-2 mx-1 border-t border-white/10';
    $navLinkClasses = 'w-full justify-start px-2 cursor-pointer
    flex items-center min-h-10 gap-3 overflow-hidden rounded-lg
    text-label-small text-on-surface
    hover:bg-white/5 hover:text-white
    transition-[width,padding,color,background-color] duration-300
    group-data-[expanded=false]/sidebar:px-2.5 group-data-[compact=true]/sidebar:w-10! group-data-[compact=true]/sidebar:aspect-square!
    group-data-[compact=true]/sidebar:justify-center! group-data-[compact=true]/sidebar:px-0! group-data-[compact=true]/sidebar:mx-auto!
    ease-in-out group whitespace-nowrap';
@endphp

<script>
    const storageKey = '{{ $sidebarStorageKey }}';
    const defaultCollapsed = window.matchMedia('(max-width: 1200px)').matches;

    try {
        const savedCollapsed = localStorage.getItem(storageKey);
        const shouldStartCollapsed = savedCollapsed === 'true'
            || (savedCollapsed !== 'false' && defaultCollapsed);

        document.documentElement.dataset.sidebarCollapsed = String(shouldStartCollapsed);
    } catch (error) {
        document.documentElement.dataset.sidebarCollapsed = String(defaultCollapsed);
    }
</script>

<style>
    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-menu] {
        width: 3.5rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-logo-link] {
        height: 4.5rem;
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-logo-wrapper] {
        width: 2.5rem;
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-logo-full] {
        opacity: 0;
        pointer-events: none;
        transform: scale(0.75);
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-logo-icon] {
        opacity: 1;
        pointer-events: auto;
        transform: scale(1);
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-account] {
        width: 2.5rem;
        padding: 0;
        aspect-ratio: 1;
        background-color: transparent;
        justify-content: flex-start;
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-label] {
        display: none !important;
    }

    html:not([data-sidebar-ready="true"])[data-sidebar-collapsed="true"] [data-sidebar-compact-link] {
        width: 2.5rem !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
        aspect-ratio: 1 !important;
        justify-content: center !important;
    }
</style>

<aside
    data-sidebar-menu
    data-sidebar-storage-key="{{ $sidebarStorageKey }}"
    x-data="(() => {
        const storageKey = $el.dataset.sidebarStorageKey;
        const defaultCollapsed = window.matchMedia('(max-width: 1200px)').matches;
        const getSavedCollapsed = () => {
            try {
                const savedCollapsed = localStorage.getItem(storageKey);

                if (savedCollapsed === 'true') {
                    return true;
                }

                if (savedCollapsed === 'false') {
                    return false;
                }
            } catch (error) {}

            return defaultCollapsed;
        };
        const saveCollapsed = (collapsed) => {
            try {
                localStorage.setItem(storageKey, String(collapsed));
            } catch (error) {}
        };
        const shouldStartCollapsed = getSavedCollapsed();

        return {
            collapsed: shouldStartCollapsed,
            compact: shouldStartCollapsed,
            collapseTimer: null,
            toggleMenu() {
                clearTimeout(this.collapseTimer);
                this.collapseTimer = null;

                if (this.collapsed) {
                    this.compact = false;
                    this.collapsed = false;
                    saveCollapsed(false);
                    return;
                }

                this.collapsed = true;
                saveCollapsed(true);
                this.collapseTimer = setTimeout(() => {
                    this.compact = true;
                    this.collapseTimer = null;
                }, 300);
            },
        };
    })()"
    x-init="$nextTick(() => document.documentElement.dataset.sidebarReady = 'true')"
    data-expanded="true"
    x-bind:data-expanded="!collapsed ? 'true' : 'false'"
    data-compact="false"
    x-bind:data-compact="compact ? 'true' : 'false'"
    {{ $attributes->merge(['class' => 'group/sidebar w-64 px-3 data-[expanded=false]:w-14 data-[expanded=false]:px-2 bg-secondary-container text-white sticky top-0 self-start h-[100vh] flex flex-col overflow-hidden shrink-0 transition-[width,padding] duration-300 ease-in-out']) }}>

    <a href="#"
       data-sidebar-logo-link
       class="h-25 group-data-[expanded=false]/sidebar:h-18 flex items-center justify-center py-3 transition-[height] duration-300">
        <div data-sidebar-logo-wrapper
             class="w-full group-data-[expanded=false]/sidebar:w-10 relative flex items-center justify-center h-16 transition-[width] duration-300 ease-in-out">
            <img data-sidebar-logo-full
                 class="opacity-100 scale-100 group-data-[expanded=false]/sidebar:opacity-0 group-data-[expanded=false]/sidebar:scale-75 group-data-[expanded=false]/sidebar:pointer-events-none absolute h-16 max-w-none shrink-0 transition-all duration-300 object-contain"
                 src="{{ asset('storage/img/logo-cnapne.png') }}" alt="CNAPNE">
            <img data-sidebar-logo-icon
                 class="opacity-0 scale-75 pointer-events-none group-data-[expanded=false]/sidebar:opacity-100 group-data-[expanded=false]/sidebar:scale-100 group-data-[expanded=false]/sidebar:pointer-events-auto absolute h-10 w-10 shrink-0 transition-all duration-300 object-contain"
                 src="{{ asset('storage/img/logo-cnapne-sem-texto.png') }}" alt="CNAPNE">
        </div>
    </a>

    <div class="flex justify-center py-2">
        <a href="#"
           data-sidebar-account
           class="w-full justify-start gap-3 pr-3 bg-secondary hover:bg-white/5 group-data-[expanded=false]/sidebar:w-10 group-data-[expanded=false]/sidebar:aspect-square group-data-[expanded=false]/sidebar:justify-start group-data-[expanded=false]/sidebar:p-0 group-data-[expanded=false]/sidebar:bg-transparent group-data-[expanded=false]/sidebar:hover:bg-transparent flex items-center h-10 overflow-hidden rounded-full transition-[width,padding,background-color] duration-300 ease-in-out text-white"
           title="{{ $user->nome }}">
            <img src="{{ asset($user->avatar) ?? asset('storage/img/placeholder-user.png') }}" alt="Imagem do usuário"
                 class="h-10 w-10 object-cover rounded-full shrink-0">
            <span data-sidebar-label x-show="!collapsed"
                  class="text-label-medium truncate">{{ $user->nome }}</span>
        </a>
    </div>

    <div class="{{ $dividerClasses }}"></div>

    <nav class="flex flex-1 flex-col items-stretch overflow-x-hidden py-2">
        @foreach ($navItems as $item)
            @if ($item['divider'] ?? false)
                <div class="{{ $dividerClasses }}"></div>
                @continue
            @endif

            @if(($item['method'] ?? 'GET') !== 'GET')
                <form action="{{ $item['href'] ?? '#' }}" method="{{$item['method']}}" draggable="false"
                      data-sidebar-compact-link>
                    @csrf
                    <button type="submit" title="{{ $item['label'] }}" class="{{ $navLinkClasses }}">
                        @else
                            <a href="{{ $item['href'] ?? '#' }}" draggable="false"
                               data-sidebar-compact-link
                               title="{{ $item['label'] }}"
                               class="{{ $navLinkClasses }}">
                                @endif
                                @if (isset($item['icon']))
                                    <x-icon
                                        class="{{($item['red'] ?? false) ? 'text-red group-hover:text-error pl-1' : 'text-primary group-hover:text-primary-accent'}} shrink-0"
                                        size="24">{{ $item['icon'] }}</x-icon>
                                @endif
                                <span data-sidebar-label x-show="!collapsed" class="truncate">
                    {{ $item['label'] }}
                </span>
                            @if(($item['method'] ?? 'GET') !== 'GET')
                    </button>
                </form>
                @else
                    </a>
            @endif
        @endforeach
    </nav>

    <div class="mt-auto flex justify-center py-2">
        <button x-on:click="toggleMenu()"
                data-sidebar-compact-link
                class="w-full cursor-pointer justify-start px-2 group-data-[expanded=false]/sidebar:px-2.5 group-data-[compact=true]/sidebar:w-10! group-data-[compact=true]/sidebar:aspect-square! group-data-[compact=true]/sidebar:justify-center! group-data-[compact=true]/sidebar:px-0! group-data-[compact=true]/sidebar:mx-auto! flex items-center h-10 gap-3 rounded-lg text-white hover:bg-white/5 transition-[width,padding,background-color] duration-300 ease-in-out overflow-hidden whitespace-nowrap">
            <span class="material-symbols-outlined text-[20px] shrink-0"
                  x-text="collapsed ? 'keyboard_double_arrow_right' : 'keyboard_double_arrow_left'">
            </span>
            <span data-sidebar-label x-show="!collapsed" class="text-label-small truncate">
                Recolher menu
            </span>
        </button>
    </div>
</aside>
