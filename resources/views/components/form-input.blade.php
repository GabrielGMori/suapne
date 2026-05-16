@props([
    'type' => 'text', // Tipo do input. Pode ser: text|password|password_forgot|date|datetime|select|multiselect|textarea|file

    'appearance' => 'default', // Aparência do input. Pode ser: default|outlined|surface
    'size' => 'medium', // Tamanho do input. Pode ser: tiny|small|medium|large|full

    'label' => null, // Texto do label associado ao input
    'name' => '', // Nome do campo, usado para o atributo name do input. É o nome passado para o controller
    'placeholder' => '', // Texto do placeholder do input
    'value' => '', // Valor padrão do input. Normalmente usado para preencher o campo com um valor existente
    'helper' => '', // Texto de ajuda em baixo do input

    'options' => [], // Opções para os tipos select e multiselect. Deve ser um array de strings
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
    $oldInputName = $emptyMultiSelectName ?: $name;
    $currentValue = $oldInputName !== '' ? old($oldInputName, $value) : $value;

    $initialSelected = $currentValue;
    if (!is_array($initialSelected)) {
        $initialSelected = ($initialSelected === '' || $initialSelected === null) ? [] : [$initialSelected];
    }
    $initialSelected = array_values(array_map('strval', $initialSelected));

    $optionsForJs = [];
    foreach ($options as $optionIndex => $optionValue) {
        $optionsForJs[] = ['index' => (string) $optionIndex, 'value' => (string) $optionValue];
    }
@endphp

<div
    {{ $attributes->merge(['class' => $fieldClass]) }}
    data-is-multiple="{{ $isMultiSelect ? 'true' : 'false' }}"
    data-options='@json($optionsForJs)'
    data-selected-items='@json($initialSelected)'
    x-data="{
        storageKey: 'form-input-selected_{{ $name }}',
        showPassword: false,
        isOpen: false,
        isMultiple: $el.dataset.isMultiple === 'true',
        options: JSON.parse($el.dataset.options),
        selectedItems: JSON.parse($el.dataset.selectedItems),
        searchQuery: '',
        searchTimeout: null,
        resetNextType: false,
        highlightedIndex: 0,

        init() {
            const stored = sessionStorage.getItem(this.storageKey);
            if (stored) {
                const parsed = JSON.parse(stored);
                if (Array.isArray(parsed)) {
                    this.selectedItems = parsed;
                } else if (typeof parsed === 'string') {
                    this.selectedItems = [parsed];
                }
                sessionStorage.removeItem(this.storageKey);
            }

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
        },
        get displayOptions() {
            if (!this.searchQuery) return this.options;

            const query = this.searchQuery.toLowerCase();
            return [...this.options]
                .filter(opt => opt.value.toLowerCase().includes(query))
                .sort((a, b) => {
                    const indexA = a.value.toLowerCase().indexOf(query);
                    const indexB = b.value.toLowerCase().indexOf(query);
                    return indexA - indexB;
                });
        },
        selectedOptions() {
            return this.options.filter((option) => this.selectedItems.includes(String(option.value)));
        },
        isSelected(optionIndex) {
            return this.selectedItems.includes(String(this.options[optionIndex].value));
        },
        resetSearch() {
            this.resetNextType = true;
            clearTimeout(this.searchTimeout);
            this.searchTimeout = null;
        },
        storeSelectedInSession() {
            sessionStorage.setItem(
                this.storageKey,
                JSON.stringify(this.selectedItems)
            );
        },
        toggleOption(optionIndex) {
            const normalized = String(this.options[optionIndex].value);
            if (this.isMultiple) {
                if (this.isSelected(optionIndex)) {
                    this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
                    this.resetSearch();
                    this.storeSelectedInSession();
                    return;
                }
                this.selectedItems = [...this.selectedItems, normalized];
                this.resetSearch();
            } else {
                this.selectedItems = [normalized];
                this.resetSearch();
                this.isOpen = false;
            }
            this.storeSelectedInSession();
        },
        removeOption(optionIndex) {
            const normalized = String(this.options[optionIndex].value);
            this.selectedItems = this.selectedItems.filter((item) => item !== normalized);
            this.storeSelectedInSession();
        },
        clearSelections() {
            this.selectedItems = [];
            this.storeSelectedInSession();
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
                        this.toggleOption(this.displayOptions[this.highlightedIndex].index);
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
    x-on:click.outside="isOpen = false"
>
    @if ($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap">
        @if ($isDropdown)
            <div
                class="multi-select {{ $sizeClass }}"
                tabindex="0"
                x-on:keydown="handleKeydown"
                x-on:focusout="if (!$el.contains($event.relatedTarget)) isOpen = false"
            >
                <button
                    type="button"
                    class="multi-select-control {{ $controlClass }}"
                    x-on:click="isOpen = !isOpen"
                >
                    <div x-show="selectedItems.length" class="w-full text-left">
                        <template x-if="isMultiple">
                            <div class="multi-select-chips">
                                <template x-for="option in selectedOptions()" x-bind:key="option.index">
                                    <span class="multi-select-chip">
                                        <button type="button" class="multi-select-chip-remove" x-on:click.stop="removeOption(option.index)">&times;</button>
                                        <span x-text="option.value"></span>
                                    </span>
                                </template>
                            </div>
                        </template>

                        <template x-if="!isMultiple">
                            <span class="block truncate" x-text="selectedOptions()[0]?.value"></span>
                        </template>
                    </div>

                    <span x-show="!selectedItems.length" class="text-black/40">{{ $resolvedPlaceholder }}</span>
                </button>

                <button type="button" x-show="selectedItems.length && isMultiple" class="multi-select-clear" x-on:click="clearSelections()" aria-label="Limpar seleção">&times;</button>

                <div x-show="isOpen" x-cloak x-ref="menu" class="multi-select-menu">
                    <template x-if="displayOptions.length === 0">
                        <div class="multi-select-option text-black/50 cursor-not-allowed">
                            Sem resultados
                        </div>
                    </template>

                    <template x-for="(option, index) in displayOptions" x-bind:key="option.index">
                        <button
                            type="button"
                            class="multi-select-option"
                            x-bind:class="{
                                'multi-select-option-selected': isSelected(option.index),
                                'bg-black/5': highlightedIndex === index
                            }"
                            x-on:click="toggleOption(option.index)"
                            x-on:mouseenter="highlightedIndex = index"
                        >
                            <span x-text="option.value"></span>
                            @if ($isMultiSelect) <span x-show="isSelected(option.index)">&times;</span> @endif
                        </button>
                    </template>
                </div>

                @if ($submittedName !== '')
                    <template x-if="isMultiple">
                        <template x-for="selectedItem in selectedItems" x-bind:key="selectedItem">
                            <input type="hidden" name="{{ $submittedName }}" x-bind:value="selectedItem" />
                        </template>
                    </template>
                @endif

                @if ($name !== '')
                    <template x-if="!isMultiple && selectedItems.length">
                        <input type="hidden" name="{{ $name }}" x-bind:value="selectedItems[0]" />
                    </template>
                @endif

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
                    x-bind:type="showPassword ? 'text' : 'password'"
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
                <button type="button" class="form-password-toggle" aria-label="Mostrar senha" x-on:click="showPassword = !showPassword">
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
