@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'helper' => null,
    'size' => 'medium',
    'appearance' => 'default',
    'mask' => null,
    'error' => null,
    'passwordForgotUrl' => route('password.forgot'),
])

@php
    use Illuminate\Support\Carbon;

    $oldName = trim(preg_replace('/\[([^\]]*)\]/', '.$1', $name), '.');
    $value = old($oldName, $value);
    $error ??= $errors->first($oldName);

    $isTypePassword = $type === 'password' || $type === 'password_forgot';
    $isTextarea = $type === 'textarea';

    $resolvedType = match (true) {
        $type === 'datetime' => 'datetime-local',
        $isTypePassword => 'password',
        default => $type,
    };

    $resolvedPlaceholder = $placeholder !== null && $placeholder !== '' ? $placeholder : match (true) {
        $type === 'datetime' => 'DD/MM/AAAA 00:00',
        $type === 'date' => 'DD/MM/AAAA',
        default => '',
    };

    $baseClass = trim("form-control form-control-{$appearance} form-control-{$size}");
    $resolvedClass = $isTextarea ? "{$baseClass} form-control-textarea" : $baseClass;
    $resolvedClass .= $error ? ' form-control-error' : '';

    $resolvedMask = match (true) {
        $mask !== null => trim($mask),
        $type === 'tel' => '+55 (99) 99999-9999',
        default => '',
    };

    if ($value instanceof Carbon) {
        $value = $type === 'date' ? $value->format('Y-m-d') : $value->format('Y-m-d\TH:i');
    }
@endphp

<div class="form-field {{ $size === 'full' ? '' : 'w-max' }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label form-label-{{ $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap" x-data="{ showPassword: false }">
        @if ($isTextarea)
            <textarea
                {{ $attributes->merge(['class' => $resolvedClass]) }}
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $resolvedPlaceholder }}"
            >{{ $value }}</textarea>
        @else
            <input
                {{ $attributes->merge(['class' => $resolvedClass]) }}
                id="{{ $name }}"
                name="{{ $name }}"
                type="{{ $isTypePassword ? 'password' : $resolvedType }}"
                @if ($isTypePassword) x-bind:type="showPassword ? 'text' : 'password'" @endif
                placeholder="{{ $resolvedPlaceholder }}"
                value="{{ $value }}"
                @if ($resolvedMask) x-mask="{{ $resolvedMask }}" @endif
            />

            @if ($isTypePassword)
                <button type="button" class="form-password-toggle" aria-label="Mostrar senha"
                    x-on:click="showPassword = !showPassword">
                    <span class="material-symbols-outlined" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                </button>
            @endif
        @endif
    </div>

    <div class="h-5">
        @if($error)
            <p class="text-error text-center form-control-{{$size}} self-center text-body-small">{{ $error }}</p>
        @endif
    </div>

    @if ($type === 'password_forgot' && !$helper)
        <a href="{{ $passwordForgotUrl }}" class="form-helper">Esqueceu ou deseja alterar sua senha?</a>
    @elseif ($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
