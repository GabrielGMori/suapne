@props([
    'full' => true, // Exibe ou oculta a seção de "Links úteis". Pode ser: true|false
])

<footer {{ $attributes->merge(['class' => 'bg-secondary-container text-white w-full']) }}>
    <div class="pl-35 pr-60 pt-10 pb-15 ">
        <div class="flex flex-col md:flex-row justify-between items-start gap-15">
            <img src="{{ asset('storage/img/logo-cnapne-sem-texto.png') }}"
                alt="CNAPNE" class="h-35">

            <div>
                <h4 class="text-title-medium text-white mb-2">Sobre</h4>
                <p class="text-body-medium text-on-surface leading-relaxed max-w-140">
                    O Sistema Unificado para Atendimento à Pessoas com
                    Necessidades Específicas (SUAPNE) foi criado como projeto de
                    TCC de Informática no IFPR Campus Curitiba.
                </p>
            </div>

            @if($full)
                <div>
                    <h4 class="text-title-medium text-white mb-2">Links úteis</h4>
                    <ul class="space-y-1">
                        <li><a href="{{ route('dashboard.index') }}" class="text-body-medium text-on-surface hover:text-white transition-colors duration-150">Início</a></li>
                        <li><a href="{{ route('estudantes.index') }}" class="text-body-medium text-on-surface hover:text-white transition-colors duration-150">Estudantes</a></li>
                        <li><a href="{{ route('planos-trabalho.index') }}" class="text-body-medium text-on-surface hover:text-white transition-colors duration-150">Planos de Trabalho</a></li>
                        <li><a href="#" class="text-body-medium text-on-surface hover:text-white transition-colors duration-150">Minha Conta</a></li>
                    </ul>
                </div>
            @endif

            <div>
                <h4 class="text-title-medium text-white mb-2">Informações técnicas</h4>
                <p class="text-body-medium text-on-surface">
                    Última atualização: {{ now()->format('d/m/Y \à\s H:i') }}
                </p>
            </div>
        </div>
    </div>
</footer>
