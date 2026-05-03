@props([
    'type' => 'default',

    'appearance' => 'default',
    'size' => 'medium',

    'label' => null,
    'name' => '',
    'value' => '',
    'placeholder' => '',

    'multiple' => false,
    'options' => [],
    'helper' => '',
])

@php
    $isDate = in_array($type, ['date', 'datetime'], true);
    $isSelect = in_array($type, ['dropdown', 'dropdown_small'], true);
    $isMultiSelect = $type === 'multiselect';

    $sizeClass = match ($size) {
        'tiny' => 'form-control-tiny',
        'small' => 'form-control-small',
        'large' => 'form-control-large',
        default => 'form-control-medium',
    };

    $appearanceClass = match ($appearance) {
        'outlined' => 'form-control-outlined',
        'soft' => 'form-control-soft',
        default => 'form-control-default',
    };

    $controlClass = trim("form-control {$appearanceClass} {$sizeClass}");
    $inputType = match (true) {
        in_array($type, ['password', 'password_forgot'], true) => 'password',
        $type === 'date' => 'date',
        $type === 'datetime' => 'datetime-local',
        default => 'text',
    };

    $resolvedPlaceholder = match (true) {
        $placeholder !== '' => $placeholder,
        $type === 'password' || $type === 'password_forgot' => 'Digite sua senha',
        $type === 'datetime' => 'DD/MM/AAAA 00:00',
        $type === 'date' => 'DD/MM/AAAA',
        $isSelect || $type === 'modal_select' || $isMultiSelect => 'Selecionar',
        default => 'Digite aqui',
    };

    $submittedName = ($multiple || $isMultiSelect) && $name && !str_ends_with($name, '[]') ? "{$name}[]" : $name;

    $initialSelected = old($name, $value);
    if (!is_array($initialSelected)) {
        $initialSelected = ($initialSelected === '' || $initialSelected === null) ? [] : [$initialSelected];
    }
    $initialSelected = array_values(array_map('strval', $initialSelected));

    $optionsForJs = [];
    foreach ($options as $optionValue => $optionLabel) {
        $optionsForJs[] = ['value' => (string) $optionValue, 'label' => (string) $optionLabel];
    }
@endphp

<div
    class="form-field"
    x-data="{
        showPassword: false,
        multiOpen: false,
        multiOptions: @js($optionsForJs),
        selectedItems: @js($initialSelected),
        selectedOptions() {
            return this.multiOptions.filter((option) => this.selectedItems.includes(String(option.value)));
        },
        isSelected(optionValue) {
            return this.selectedItems.includes(String(optionValue));
        },
        toggleOption(optionValue) {
            const normalized = String(optionValue);
            if (this.isSelected(normalized)) {
                this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
                return;
            }
            this.selectedItems.push(normalized);
        },
        removeOption(optionValue) {
            const normalized = String(optionValue);
            this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
        },
        clearSelections() {
            this.selectedItems = [];
        }
    }"
    @click.outside="multiOpen = false"
>
    @if ($label)
        <label for="{{ $name }}" class="{{ $appearance === 'outlined' ? 'form-label-outlined' : 'form-label' }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap w-full">
        @if ($isSelect)
            <select
                name="{{ $submittedName }}"
                @if ($multiple) multiple @endif
                {{ $attributes->merge(['class' => trim($controlClass . ' ' . ($multiple ? 'form-control--multiselect' : 'form-control--select') . ' ' . ($type === 'dropdown_small' ? 'form-control--tiny' : ''))]) }}>
                @unless ($multiple)
                    <option value="">{{ $resolvedPlaceholder }}</option>
                @endunless
                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                @endforeach
            </select>

            @unless ($multiple)
                <span class="form-caret {{ $type === 'dropdown_small' ? 'form-caret--small' : '' }}"></span>
            @endunless
        @elseif ($isMultiSelect)
            <div class="multi-select">
                <button
                    type="button"
                    class="multi-select__control"
                    @click="multiOpen = !multiOpen"
                >
                    <div class="multi-select__chips" x-show="selectedItems.length">
                        <template x-for="option in selectedOptions()" :key="option.value">
                            <span class="multi-select__chip">
                                <button type="button" class="multi-select__chip-remove" @click.stop="removeOption(option.value)">x</button>
                                <span x-text="option.label"></span>
                            </span>
                        </template>
                    </div>
                    <span x-show="!selectedItems.length" class="text-black/40">{{ $resolvedPlaceholder }}</span>
                </button>

                <button type="button" x-show="selectedItems.length" class="multi-select__clear" @click="clearSelections()" aria-label="Limpar seleção">x</button>

                <div x-show="multiOpen" x-cloak class="multi-select__menu">
                    <template x-for="option in multiOptions" :key="option.value">
                        <button
                            type="button"
                            class="multi-select__option"
                            :class="{ 'multi-select__option--selected': isSelected(option.value) }"
                            @click="toggleOption(option.value)"
                        >
                            <span x-text="option.label"></span>
                            <span x-show="isSelected(option.value)">x</span>
                        </button>
                    </template>
                </div>

                <template x-for="selectedItem in selectedItems" :key="selectedItem">
                    <input type="hidden" name="{{ $submittedName }}" :value="selectedItem" />
                </template>
            </div>
        @elseif ($type === 'textarea')
            <textarea
                name="{{ $name }}"
                placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass . ' form-control--textarea']) }}>{{ old($name, $value) }}</textarea>
        @elseif ($type === 'file')
            <input
                name="{{ $name }}"
                type="file"
                {{ $attributes->merge(['class' => $controlClass]) }} />
        @elseif ($isDate)
            <input
                name="{{ $name }}"
                type="{{ $inputType }}"
                value="{{ old($name, $value) }}"
               placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass]) }}
            />
        @else
            <input
                name="{{ $name }}"
                type="{{ $inputType }}"
                @if (in_array($type, ['password', 'password_forgot'], true))
                    :type="showPassword ? 'text' : 'password'"
                @endif
                value="{{ old($name, $value) }}"
                placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass]) }}
            />

            @if (in_array($type, ['password', 'password_forgot'], true))
                <button type="button" class="form-password-toggle" aria-label="Mostrar senha" @click="showPassword = !showPassword">
                    <span class="material-symbols-outlined text-[22px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                </button>
            @endif
        @endif
    </div>

    @if ($type === 'password_forgot' && !$helper)
        <a href="#" class="form-helper form-helper--center">Esqueceu ou deseja alterar sua senha?</a>
    @elseif ($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
