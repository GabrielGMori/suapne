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
    $isPassword = in_array($type, ['password', 'password_forgot'], true);
    $isTextarea = $type === 'textarea';
    $isFile = $type === 'file';

    $sizeClass = "form-control-$size";
    $controlClass = trim("form-control form-control-{$appearance} {$sizeClass}");
    $fieldClass = trim('form-field ' . ($size === 'full' ? '' : 'w-max'));
    $labelClass = "form-label form-label-{$appearance}";
    $textareaClass = "{$controlClass} form-control-textarea";
    $fileClass = "{$controlClass} form-control-file";
    $nativeInputClass = $isFile ? $fileClass : $controlClass;
    $caretClass = trim('form-caret ' . ($size === 'small' ? 'form-caret-small' : ''));

    $inputType = match (true) {
        $isPassword => 'password',
        $type === 'date' => 'date',
        $type === 'datetime' => 'datetime-local',
        default => $type,
    };

    $resolvedPlaceholder = match (true) {
        $placeholder !== '' => $placeholder,
        $isPassword => 'Digite sua senha',
        $type === 'datetime' => 'DD/MM/AAAA 00:00',
        $type === 'date' => 'DD/MM/AAAA',
        $isDropdown => '',
        default => '',
    };

    $submittedName = $isMultiSelect && $name && !str_ends_with($name, '[]') ? "{$name}[]" : $name;
    $emptyMultiSelectName = str_replace('[]', '', $name);
    $currentValue = old($name, $value);

    $initialSelected = $currentValue;
    if (!is_array($initialSelected)) {
        $initialSelected = ($initialSelected === '' || $initialSelected === null) ? [] : [$initialSelected];
    }
    $initialSelected = array_values(array_map('strval', $initialSelected));

    $optionsForJs = [];
    foreach ($options as $optionValue => $optionLabel) {
        $optionsForJs[] = ['value' => (string) $optionValue, 'label' => (string) $optionLabel];
    }

    $selectionStorageId = $name !== ''
        ? $name
        : sha1(json_encode([$type, $appearance, $size, $label, $placeholder, $optionsForJs], JSON_UNESCAPED_UNICODE));
@endphp

<div
    {{ $attributes->merge(['class' => $fieldClass]) }}
    x-data="{
        showPassword: false,
        isOpen: false,
        isMultiple: @js($isMultiSelect),
        options: @js($optionsForJs),
        selectedItems: @js($initialSelected),
        searchQuery: '',
        searchTimeout: null,
        resetNextType: false,
        highlightedIndex: 0,
        shouldPersistSelection: @js($isDropdown),
        selectionStorageKey: ['cnapne.form-input', window.location.pathname, @js($selectionStorageId)].join('.'),

        init() {
            this.restoreSelection();

            this.$watch('isOpen', value => {
                if (!value) {
                    this.searchQuery = '';
                    this.resetNextType = false;
                    this.highlightedIndex = 0;
                }
            });

            this.$watch('searchQuery', () => {
                this.highlightedIndex = 0;
            });

            this.$watch('selectedItems', () => {
                this.saveSelection();
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
        resetSearch() {
            this.resetNextType = true;
            clearTimeout(this.searchTimeout);
            this.searchTimeout = null;
        },
        validSelectedItems(items) {
            const optionValues = this.options.map((option) => String(option.value));
            return items
                .map((item) => String(item))
                .filter((item) => optionValues.includes(item));
        },
        restoreSelection() {
            if (!this.shouldPersistSelection) return;

            try {
                const savedValue = localStorage.getItem(this.selectionStorageKey);
                if (savedValue === null) return;

                const savedSelection = JSON.parse(savedValue);
                const selectedItems = Array.isArray(savedSelection) ? this.validSelectedItems(savedSelection) : [];

                this.selectedItems = this.isMultiple ? selectedItems : selectedItems.slice(0, 1);
            } catch (error) {}
        },
        saveSelection() {
            if (!this.shouldPersistSelection) return;

            try {
                localStorage.setItem(this.selectionStorageKey, JSON.stringify(this.selectedItems));
            } catch (error) {}
        },
        toggleOption(optionValue) {
            const normalized = String(optionValue);
            if (this.isMultiple) {
                if (this.isSelected(normalized)) {
                    this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
                    this.resetSearch();
                    return;
                }
                this.selectedItems = [...this.selectedItems, normalized];
                this.resetSearch();
            } else {
                this.selectedItems = [normalized];
                this.resetSearch();
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
            if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(e.key)) {
                if (e.key === 'Escape') {
                    this.isOpen = false;
                    return;
                }

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
        <label for="{{ $name }}" class="{{ $labelClass }}">{{ $label }}</label>
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

                <div x-show="isOpen" x-cloak x-ref="menu" class="multi-select-menu">
                    <template x-if="displayOptions.length === 0">
                        <div class="multi-select-option text-black/50 cursor-not-allowed">
                            Sem resultados
                        </div>
                    </template>

                    <template x-for="(option, index) in displayOptions" :key="option.value">
                        <button
                            type="button"
                            class="multi-select-option"
                            :class="{
                                'multi-select-option-selected': isSelected(option.value),
                                'bg-black/5': highlightedIndex === index
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
                    <input type="hidden" name="{{ $emptyMultiSelectName }}" value="" />
                @endif

                <template x-if="isMultiple">
                    <template x-for="selectedItem in selectedItems" :key="selectedItem">
                        <input type="hidden" name="{{ $submittedName }}" :value="selectedItem" />
                    </template>
                </template>

                <template x-if="!isMultiple">
                    <input type="hidden" name="{{ $name }}" :value="selectedItems.length ? selectedItems[0] : ''" />
                </template>

                <span x-show="!selectedItems.length || !isMultiple" class="{{ $caretClass }}"></span>
            </div>

        @elseif ($isTextarea)
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $resolvedPlaceholder }}"
                {{ $attributes->merge(['class' => $textareaClass]) }}>{{ $currentValue }}</textarea>
        @else
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                @if ($isPassword)
                    :type="showPassword ? 'text' : 'password'"
                @else
                    type="{{ $inputType }}"
                @endif
                @unless ($isFile)
                    value="{{ $currentValue }}"
                    placeholder="{{ $resolvedPlaceholder }}"
                @endunless
                {{ $attributes->merge(['class' => $nativeInputClass]) }}
            />

            @if ($isPassword)
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
