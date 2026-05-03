@props([
    'type' => 'text',

    'appearance' => 'default',
    'size' => 'medium',

    'label' => null,
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'helper' => '',

    'options' => [],
])

@php
    $isDate = in_array($type, ['date', 'datetime'], true);
    $isSelect = $type === 'select';
    $isMultiSelect = $type === 'multiselect';

    $sizeClass = "form-control-$size";

    $appearanceClass = match ($appearance) {
        'outlined' => 'form-control-outlined',
        'surface' => 'form-control-surface',
        default => 'form-control-default',
    };

    $controlClass = trim("form-control {$appearanceClass} {$sizeClass}");
    $inputType = match (true) {
        in_array($type, ['password', 'password_forgot'], true) => 'password',
        $type === 'date' => 'date',
        $type === 'datetime' => 'datetime-local',
        default => $type,
    };

    $resolvedPlaceholder = match (true) {
        $placeholder !== '' => $placeholder,
        $type === 'password' || $type === 'password_forgot' => 'Digite sua senha',
        $type === 'datetime' => 'DD/MM/AAAA 00:00',
        $type === 'date' => 'DD/MM/AAAA',
        $isSelect || $type === 'modal_select' || $isMultiSelect => 'Selecionar',
        default => 'Digite aqui',
    };

    $submittedName = $isMultiSelect && $name && !str_ends_with($name, '[]') ? "{$name}[]" : $name;

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
    class="form-field {{ $size == 'full' ? '' : 'w-max' }}"
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
        <label for="{{ $name }}" class="form-label {{ 'form-label-' . $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap">
        @if ($isSelect)
            <select
                id="{{ $name }}"
                name="{{ $submittedName }}"
                {{ $attributes->merge(['class' => trim($controlClass . ' form-control-select')]) }}>
                <option value="" selected disabled>{{ $resolvedPlaceholder }}</option>
                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
                @endforeach
            </select>

            <span class="form-caret {{ $size === 'small' ? 'form-caret-small' : '' }}"></span>
        @elseif ($isMultiSelect)
            <div class="multi-select {{ $sizeClass }}">
                <button
                    type="button"
                    class="multi-select-control {{ $sizeClass }}"
                    @click="multiOpen = !multiOpen"
                >
                    <div class="multi-select-chips" x-show="selectedItems.length">
                        <template x-for="option in selectedOptions()" :key="option.value">
                            <span class="multi-select-chip">
                                <button type="button" class="multi-select-chip-remove" @click.stop="removeOption(option.value)">&times;</button>
                                <span x-text="option.label"></span>
                            </span>
                        </template>
                    </div>
                    <span x-show="!selectedItems.length" class="text-black/40">{{ $resolvedPlaceholder }}</span>
                </button>

                <button type="button" x-show="selectedItems.length" class="multi-select-clear" @click="clearSelections()" aria-label="Limpar seleção">&times;</button>

                <div x-show="multiOpen" x-cloak class="multi-select-menu">
                    <template x-for="option in multiOptions" :key="option.value">
                        <button
                            type="button"
                            class="multi-select-option"
                            :class="{ 'multi-select-option-selected': isSelected(option.value) }"
                            @click="toggleOption(option.value)"
                        >
                            <span x-text="option.label"></span>
                            <span x-show="isSelected(option.value)">&times;</span>
                        </button>
                    </template>
                </div>

                <input type="hidden" name="{{ $name }}" value="" />
                <template x-for="selectedItem in selectedItems" :key="selectedItem">
                    <input type="hidden" name="{{ $submittedName }}" :value="selectedItem" />
                </template>

                <span x-show="!selectedItems.length" class="form-caret {{ $size === 'small' ? 'form-caret-small' : '' }}"></span>
            </div>
        @elseif ($type === 'textarea')
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass . ' form-control-textarea']) }}>{{ old($name, $value) }}</textarea>
        @elseif ($type === 'file')
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="file"
                {{ $attributes->merge(['class' => $controlClass . ' form-control-file']) }} />
        @elseif ($isDate)
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="{{ $inputType }}"
                value="{{ old($name, $value) }}"
               placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass]) }}
            />
        @else
            <input
                id="{{ $name }}"
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
        <a href="#" class="form-helper">Esqueceu ou deseja alterar sua senha?</a>
    @elseif ($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
