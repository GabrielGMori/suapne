<div class="form-field {{ $size === 'full' ? '' : 'w-max' }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label form-label-{{ $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap"
         x-data="{ showPassword: false }"
    >
        @if ($this->isTextarea())
            <textarea
                {{ $attributes->merge(['class' => $this->resolvedClass() . ($name && $errors->has($this->resolvedErrorName()) ? ' form-control-error' : '')]) }}
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $this->resolvedPlaceholder() }}"
                wire:model.live="value"
            ></textarea>

        @else
            <input
                {{ $attributes->merge(['class' => $this->resolvedClass() . ($name && $errors->has($this->resolvedErrorName()) ? ' form-control-error' : '')]) }}
                id="{{ $name }}"
                name="{{ $name }}"
                type="{{ $this->isTypePassword() ? 'password' : $this->resolvedType() }}"

                @if ($this->isTypePassword())
                    x-bind:type="showPassword ? 'text' : 'password'"
                @endif

                placeholder="{{ $this->resolvedPlaceholder() }}"
                wire:model.live="value"

                x-mask="{{$this->resolvedMask()}}"
            />

            @if ($this->isTypePassword())
                <button type="button" class="form-password-toggle" aria-label="Mostrar senha"
                        x-on:click="showPassword = !showPassword">
                    <span class="material-symbols-outlined"
                          x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                </button>
            @endif
        @endif
    </div>

    <div class="h-5">
        @error($this->resolvedErrorName())
            <p class="text-red text-center form-control-{{$size}} self-center text-body-small">{{ $message }}</p>
        @enderror
    </div>

    @if ($type === 'password_forgot' && !$helper)
        <a href="{{ route('cadastro.enviado') }}" class="form-helper">Esqueceu ou deseja alterar sua senha?</a>
    @elseif ($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
