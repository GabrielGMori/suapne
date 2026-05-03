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
    class="bg-secondary-container text-white w-64 sticky top-0 self-start h-screen flex flex-col overflow-hidden shrink-0">
    <a href="#" class="flex items-center justify-center gap-2 px-4 pt-5 pb-3">
        <img src="{{ asset('storage/img/logo-cnapne.png') }}" alt="CNAPNE" class="h-16 object-contain">
    </a>

    <div class="px-4 py-2">
        <a href="#"
            class="flex items-center bg-secondary hover:hover:bg-white/5 rounded-full pr-2 transition-colors  text-white duration-150 group">
            <img src="{{ asset('storage/img/placeholder-user.png') }}" alt="Usuário"
                class="h-10 w-10 object-cover rounded-full shrink-0">
            <div class="flex items-center justify-between w-full ml-3">
                <span class="text-label-medium  truncate">{{ $user ?? 'Minha conta' }}</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-2">
        <div class="my-2 mx-2 border-t border-white/10"></div>
        @foreach ($navItems as $item)
            @if (isset($item['divider']) && $item['divider'])
                <div class="my-2 mx-2 border-t border-white/10"></div>
            @else
                <a href="{{ $item['href'] ?? '#' }}"
                    class="flex items-center gap-2 px-4 py-2 text-label-small text-on-surface hover:bg-white/5 hover:text-white transition-colors duration-150 group">
                    @if (isset($item['icon']))
                        <span class="material-symbols-outlined text-[16px] text-primary group-hover:text-primary-accent shrink-0">
                            {{ $item['icon'] }}
                        </span>
                    @endif
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach

        <div class="my-2 mx-2 border-t border-white/10"></div>

        <a href="#"
            class="flex items-center gap-2 px-4 py-2 text-label-small text-on-surface hover:bg-white/5 hover:text-white transition-colors duration-150 group">
            <span class="material-symbols-outlined text-[16px] text-red group-hover:text-error shrink-0">
                logout
            </span>
            <span class="truncate">Sair</span>
        </a>
    </nav>
</aside>
