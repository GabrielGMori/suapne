@props([
    'url',
    'count',
    'text',
    'plural-text',
    'check-icon' => 'check',
    'warning-icon' => 'notification_important'
])

<div class="col-span-2 space-y-1">
    <div class="flex items-center gap-1">
        @if($planos > 0)
            <x-icon icon="notification_important" size="45"
                label="Existe{{$planos === 1 ? '' : 'm'}} {{$planos}} PTE{{$plural}} {{ $notificationType }}" />
            <x-button icon="open_in_new" size="dynamic" color="transparent" type="link"
                :href="route('planos-trabalho.index') . '?' . http_build_query(['filter' => ['status' => $status]])" />
        @else
            <x-icon icon="check" class="text-primary-accent" size="45"
                label="Não há PTEs {{ $notificationType }} no momento" />
        @endif
    </div>

    @if(!$isProfessorRegular)
        <hr class="text-on-surface my-5">
    @endif
</div>
