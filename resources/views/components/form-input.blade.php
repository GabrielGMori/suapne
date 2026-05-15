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
    $isSelect = $type === 'select';
    $isMultiSelect = $type === 'multiselect';
    $isDropdown = $isSelect || $isMultiSelect;

    $sizeClass = "form-control-$size";
    $appearanceClass = "form-control-$appearance";
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
        $isDropdown => '',
        default => '',
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
    {{ $attributes->merge(['class' => "form-field " . ($size == 'full' ? '' : 'w-max')]) }}
    x-data="{
        showPassword: false,
        isOpen: false,
        isMultiple: @js($isMultiSelect),
        options: @js($optionsForJs),
        selectedItems: @js($initialSelected),
        searchQuery: '',
        searchTimeout: null,
        resetNextType: false,
        highlightedIndex: 0, // NOVO: Controle de navegação por teclado

        init() {
            this.$watch('isOpen', value => {
                if (!value) {
                    this.searchQuery = '';
                    this.resetNextType = false;
                    this.highlightedIndex = 0;
                }
            });
            // NOVO: Reseta o índice de navegação ao buscar
            this.$watch('searchQuery', () => {
                this.highlightedIndex = 0;
            });
        },
        get displayOptions() {
            if (!this.searchQuery) return this.options;

            const query = this.searchQuery.toLowerCase();
            return [...this.options]
                .filter(opt => opt.label.toLowerCase().includes(query))
                .sort((a, b) => {
                    const indexA = a.label.toLowerCase().indexOf(query);
                    const indexB = b.label.toLowerCase().indexOf(query);
                    return indexA - indexB;
                });
        },
        selectedOptions() {
            return this.options.filter((option) => this.selectedItems.includes(String(option.value)));
        },
        isSelected(optionValue) {
            return this.selectedItems.includes(String(optionValue));
        },
        toggleOption(optionValue) {
            const normalized = String(optionValue);
            if (this.isMultiple) {
                if (this.isSelected(normalized)) {
                    this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
                    return;
                }
                this.selectedItems.push(normalized);
            } else {
                this.selectedItems = [normalized];
                this.isOpen = false;
            }
        },
        removeOption(optionValue) {
            const normalized = String(optionValue);
            this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
        },
        clearSelections() {
            this.selectedItems = [];
        },
        scrollToHighlighted() {
            this.$nextTick(() => {
                if (!this.$refs.menu) return;
                const optionNodes = this.$refs.menu.querySelectorAll('.multi-select-option:not(.cursor-not-allowed)');
                if (optionNodes[this.highlightedIndex]) {
                    optionNodes[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
                }
            });
        },
        handleKeydown(e) {
            // NOVO: Controle de Setas, Enter e Esc
            if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(e.key)) {
                if (e.key === 'Escape') {
                    this.isOpen = false;
                    return;
                }

                // Abre o menu com Enter ou Setas caso esteja fechado
                if (!this.isOpen && (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === 'Enter')) {
                    e.preventDefault();
                    this.isOpen = true;
                    return;
                }

                if (this.isOpen) {
                    e.preventDefault();

                    if (e.key === 'ArrowDown') {
                        if (this.displayOptions.length > 0) {
                            this.highlightedIndex = (this.highlightedIndex + 1) % this.displayOptions.length;
                            this.scrollToHighlighted();
                        }
                    }

                    if (e.key === 'ArrowUp') {
                        if (this.displayOptions.length > 0) {
                            this.highlightedIndex = this.highlightedIndex - 1 < 0 ? this.displayOptions.length - 1 : this.highlightedIndex - 1;
                            this.scrollToHighlighted();
                        }
                    }

                    if (e.key === 'Enter' && this.displayOptions.length > 0) {
                        this.toggleOption(this.displayOptions[this.highlightedIndex].value);
                    }
                }
                return;
            }

            // Lógica existente de Type-ahead
            if (e.key.length !== 1 || e.ctrlKey || e.altKey || e.metaKey) return;

            if (this.resetNextType) {
                this.searchQuery = e.key;
                this.resetNextType = false;
            } else {
                this.searchQuery += e.key;
            }

            this.isOpen = true;

            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.resetNextType = true;
            }, 1000);
        }
    }"
    @click.outside="isOpen = false"
>
    @if ($label)
        <label for="{{ $name }}" class="form-label {{ 'form-label-' . $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap">
        @if ($isDropdown)
            <div
                class="multi-select {{ $sizeClass }}"
                tabindex="0"
                @keydown="handleKeydown"
                @focusout="if (!$el.contains($event.relatedTarget)) isOpen = false"
            >
                <button
                    type="button"
                    class="multi-select-control {{ $controlClass }}"
                    @click="isOpen = !isOpen"
                >
                    <div x-show="selectedItems.length" class="w-full text-left">
                        <template x-if="isMultiple">
                            <div class="multi-select-chips">
                                <template x-for="option in selectedOptions()" :key="option.value">
                                    <span class="multi-select-chip">
                                        <button type="button" class="multi-select-chip-remove" @click.stop="removeOption(option.value)">&times;</button>
                                        <span x-text="option.label"></span>
                                    </span>
                                </template>
                            </div>
                        </template>

                        <template x-if="!isMultiple">
                            <span class="block truncate" x-text="selectedOptions()[0]?.label"></span>
                        </template>
                    </div>

                    <span x-show="!selectedItems.length" class="text-black/40">{{ $resolvedPlaceholder }}</span>
                </button>

                <button type="button" x-show="selectedItems.length && isMultiple" class="multi-select-clear" @click="clearSelections()" aria-label="Limpar seleção">&times;</button>

                {{-- Adicionado x-ref="menu" para referenciar no Auto-Scroll --}}
                <div x-show="isOpen" x-cloak x-ref="menu" class="multi-select-menu">
                    <template x-if="displayOptions.length === 0">
                        <div class="multi-select-option text-black/50 cursor-not-allowed">
                            Sem resultados
                        </div>
                    </template>

                    {{-- O loop agora rastreia o index para o highlight visual --}}
                    <template x-for="(option, index) in displayOptions" :key="option.value">
                        <button
                            type="button"
                            class="multi-select-option"
                            :class="{
                                'multi-select-option-selected': isSelected(option.value),
                                'bg-black/5': highlightedIndex === index // Troque 'bg-black/5' pela classe de hover que você usa no seu projeto (ex: bg-gray-100)
                            }"
                            @click="toggleOption(option.value)"
                            @mouseenter="highlightedIndex = index"
                        >
                            <span x-text="option.label"></span>
                            @if ($isMultiSelect) <span x-show="isSelected(option.value)">&times;</span> @endif
                        </button>
                    </template>
                </div>

                @if ($isMultiSelect)
                    {{-- Correção do Issue 1 (Ghost input array bug) --}}
                    <input type="hidden" name="{{ str_replace('[]', '', $name) }}" value="" />
                @endif

                <template x-if="isMultiple">
                    <template x-for="selectedItem in selectedItems" :key="selectedItem">
                        <input type="hidden" name="{{ $submittedName }}" :value="selectedItem" />
                    </template>
                </template>

                <template x-if="!isMultiple">
                    <input type="hidden" name="{{ $name }}" :value="selectedItems.length ? selectedItems[0] : ''" />
                </template>

                <span x-show="!selectedItems.length || !isMultiple" class="form-caret {{ $size === 'small' ? 'form-caret-small' : '' }}"></span>
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
        @elseif (in_array($type, ['date', 'datetime'], true))
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="{{ $inputType }}"
                value="{{ old($name, $value) }}"
               placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass]) }}
            />
        @else
            {{-- Resolvido o conflito duplo de type="{{ $inputType }}" nas senhas --}}
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                @if (in_array($type, ['password', 'password_forgot'], true))
                    :type="showPassword ? 'text' : 'password'"
                @else
                    type="{{ $inputType }}"
                @endif
                value="{{ old($name, $value) }}"
                placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $controlClass]) }}
            />

            @if (in_array($type, ['password', 'password_forgot'], true))
                <button type="button" class="form-password-toggle" aria-label="Mostrar senha" @click="showPassword = !showPassword">
                    <span class="material-symbols-outlined" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
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
