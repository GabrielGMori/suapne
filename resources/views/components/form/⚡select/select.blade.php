@php
    $optionList = $this->optionList();
    $baseClass = "form-control form-control-{$appearance} form-control-{$size}" . ($disabled ? ' bg-white/30' : '');
    $submittedName = $isMultiple && $name && !str_ends_with($name, '[]') ? "{$name}[]" : $name;
    $caretClass = 'form-caret' . ($size === 'small' ? ' form-caret-small' : '') . ($disabled ? ' hidden' : '');
@endphp

<div class="form-field {{ $size === 'full' ? '' : 'w-max' }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label form-label-{{ $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap">
        <div class="select form-control-{{ $size }}"
            x-data="formSelectData(
                @js($optionList, JSON_THROW_ON_ERROR),
                @js($isMultiple, JSON_THROW_ON_ERROR),
                @js($disabled, JSON_THROW_ON_ERROR)
            )"
            x-init="
                $watch('isOpen', v => {
                    if ($refs.menu) $refs.menu.scrollTop = 0;
                    if (!v) {
                        searchQuery = '';
                        resetNextType = false;
                        highlightedIndex = 0;
                    }
                });
                $watch('searchQuery', () => { highlightedIndex = 0; });
                $wire.on('select-options-updated', ({ options: opts }) => {
                    options = normalizeOptions(opts);
                });
            "
            x-on:keydown="handleKeydown"
            x-on:click.outside="isOpen = false"
            x-on:focusout="if (! $el.contains($event.relatedTarget)) { isOpen = false; }">
            
            <button
                type="button"
                role="combobox"
                aria-haspopup="listbox"
                :aria-expanded="isOpen"
                aria-disabled="{{ $disabled ? 'true' : 'false' }}"
                @disabled($disabled)
                class="select-control {{ $baseClass }} {{ $parentError || ($name && $errors->has($this->resolvedErrorName())) ? 'form-control-error' : '' }}"
                x-on:click="isOpen = !isOpen"
            >
                <div x-show="selected.length > 0" class="w-full text-left">
                    @if ($isMultiple && $submittedName !== '')
                        <div class="select-chips" wire:ignore>
                            <template x-for="item in selectedWithLabels" :key="item.value">
                                <span class="select-chip">
                                    @if(!$disabled)
                                        <button type="button" class="select-chip-remove"
                                            x-on:click.stop="removeOption(item.value)"
                                            :aria-label="'Remover ' + item.label">&times;</button>
                                    @endif
                                    <span x-text="item.label" :title="item.label"></span>
                                </span>
                            </template>
                        </div>
                    @endif

                    @if (!$isMultiple)
                        <span class="block truncate" x-text="labelMap[selected[0]] ?? selected[0]"></span>
                    @endif
                </div>

                <span x-show="selected.length === 0" class="text-black/40">{{ $placeholder }}</span>
            </button>

            @if(!$disabled)
                <button type="button" class="select-clear"
                    x-show="selected.length > 0 && (isMultiple || {{ $clearable ? 'true' : 'false' }})"
                    x-on:click="clearSelections()" aria-label="Limpar seleção">&times;
                </button>
            @endif

            <div x-show="isOpen" x-cloak x-ref="menu" class="select-menu" role="listbox"
                :aria-multiselectable="isMultiple" wire:ignore>
                <div x-show="searchQuery.length > 0" class="px-3 py-2 text-sm border-b sticky top-0 z-10 bg-surface">
                    Pesquisando por:
                    <span class="font-medium" x-text="searchQuery"></span>
                </div>

                <template x-if="displayOptions.length === 0">
                    <div class="select-option text-black/50 cursor-not-allowed" role="option" aria-disabled="true">
                        {{ $noResultMessage }}
                    </div>
                </template>

                <template x-for="(option, index) in displayOptions" :key="option.value">
                    <button type="button" class="select-option" role="option" :aria-selected="isSelected(option.value)"
                        :class="{
                            'select-option-selected': isSelected(option.value),
                            'select-option-highlighted': highlightedIndex === index
                        }"
                        x-on:click="toggleOption(option)"
                        x-on:mouseenter="highlightedIndex = index">
                        <span x-text="option.label"></span>
                        @if ($isMultiple)
                            <span x-show="isSelected(option.value)" aria-hidden="true">&times;</span>
                        @endif
                    </button>
                </template>
            </div>

            @if ($submittedName !== '')
                <template x-if="isMultiple">
                    <template x-for="val in selected" :key="val">
                        <input type="hidden" name="{{ $submittedName }}" :value="val" />
                    </template>
                </template>
            @endif

            @if ($name !== '')
                <template x-if="!isMultiple && selected.length > 0">
                    <input type="hidden" name="{{ $name }}" :value="selected[0]" />
                </template>
            @endif

            <span x-show="selected.length === 0 || (!isMultiple && !{{ $clearable ? 'true' : 'false' }})"
                class="{{ $caretClass }}" aria-hidden="true"></span>
        </div>
    </div>

    <div class="h-5">
        @error($this->resolvedErrorName())
            <p class="text-error text-center form-control-{{ $size }} self-center text-body-small">{{ $message }}</p>
        @enderror
        @if(filled($parentError))
            <p class="text-error text-center form-control-{{ $size }} self-center text-body-small">{{ $parentError }}</p>
        @endif
    </div>
</div>

@script
<script>
    if (typeof window.formSelectData === 'undefined') {
        window.formSelectData = function (options, isMultiple, disabled) {
            const normalizeOptions = (opts) => {
                if (!opts) return [];

                if (!Array.isArray(opts)) {
                    return Object.entries(opts)
                        .filter(([value, label]) => value !== null && value !== 'null' && label !== null && label !== undefined)
                        .map(([value, label]) => ({ value, label }));
                }

                return opts
                    .filter(option => option !== null && option !== undefined)
                    .map((option) => {
                        if (option && typeof option === 'object' && 'value' in option && 'label' in option) {
                            return { value: String(option.value), label: option.label };
                        }
                        return { value: String(option), label: option };
                    })
                    .filter(option => option.value !== null && option.value !== 'null' && option.value !== undefined);
            };

            return {
                isOpen: false,
                searchQuery: '',
                resetNextType: false,
                highlightedIndex: 0,
                errorDismissed: false,
                normalizeOptions,
                options: normalizeOptions(options),
                isMultiple,
                disabled,

                // Internally the selection is always handled as an array of strings,
                // regardless of the model shape (?string for single, array for multiple).
                get selected() {
                    const raw = this.$wire.selectedItems;
                    if (raw === null || raw === undefined || raw === '') return [];
                    return (Array.isArray(raw) ? raw : [raw]).map(String);
                },

                // Write back in the shape dictated by the model contract.
                set selected(value) {
                    this.$wire.selectedItems = this.isMultiple ? value : (value[0] ?? null);
                },

                get selectedSet() {
                    return new Set(this.selected);
                },

                get labelMap() {
                    return Object.fromEntries(this.options.map(o => [o.value, o.label]));
                },

                get selectedWithLabels() {
                    return this.selected.map(v => ({ value: v, label: this.labelMap[v] ?? v }));
                },

                normalize(text) {
                    return String(text ?? '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '');
                },

                fuzzyMatch(query, text) {
                    query = this.normalize(query);
                    text = this.normalize(text);

                    let queryIndex = 0;

                    for (let textIndex = 0; textIndex < text.length; textIndex++) {
                        if (text[textIndex] === query[queryIndex]) {
                            queryIndex++;
                        }
                        if (queryIndex === query.length) {
                            return true;
                        }
                    }
                    return false;
                },

                scoreSearch(query, text) {
                    query = this.normalize(query);
                    text = this.normalize(text);

                    if (text === query) return 1000;
                    if (text.startsWith(query)) return 900;
                    if (text.includes(query)) return 800 - text.indexOf(query);
                    if (this.fuzzyMatch(query, text)) {
                        let score = 500;
                        let queryIndex = 0;

                        for (let textIndex = 0; textIndex < text.length; textIndex++) {
                            if (text[textIndex] === query[queryIndex]) {
                                score -= textIndex;
                                queryIndex++;
                            }
                        }
                        return score;
                    }
                    return -1;
                },

                get displayOptions() {
                    if (!this.searchQuery) return this.options;

                    return this.options.map(option => ({ option, score: this.scoreSearch(this.searchQuery, option.label) }))
                        .filter(item => item.score >= 0)
                        .sort((a, b) => b.score - a.score)
                        .map(item => item.option);
                },

                isSelected(value) {
                    return this.selectedSet.has(value);
                },

                toggleOption(opt) {
                    if (this.disabled) return;

                    if (this.isMultiple) {
                        this.selected = this.isSelected(opt.value)
                            ? this.selected.filter(v => v !== opt.value)
                            : [...this.selected, opt.value];
                    } else {
                        this.selected = [opt.value];
                        this.isOpen = false;
                    }

                    this.resetSearch();
                },

                removeOption(value) {
                    if (this.disabled) return;

                    this.selected = this.selected.filter(v => v !== value);
                },

                clearSelections() {
                    if (this.disabled) return;

                    this.selected = [];
                },

                resetSearch() {
                    this.resetNextType = true;
                },

                scrollToHighlighted() {
                    this.$nextTick(() => {
                        if (!this.$refs.menu) return;
                        const nodes = this.$refs.menu.querySelectorAll('.select-option:not(.cursor-not-allowed)');
                        if (nodes[this.highlightedIndex]) {
                            nodes[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
                        }
                    });
                },

                handleKeydown(e) {
                    if (this.disabled) return;

                    if (e.key === 'Backspace') {
                        if (this.searchQuery.length > 0) {
                            e.preventDefault();
                            this.searchQuery = this.searchQuery.slice(0, -1);
                            this.isOpen = true;
                            if (this.searchQuery.length === 0) {
                                this.resetNextType = true;
                            }
                        }
                        return;
                    } else if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(e.key)) {
                        if (e.key === 'Escape') { this.isOpen = false; return; }
                        if (!this.isOpen) { e.preventDefault(); this.isOpen = true; return; }
                        e.preventDefault();
                        if (e.key === 'ArrowDown' && this.displayOptions.length > 0) {
                            this.highlightedIndex = Math.min(
                                this.highlightedIndex + 1,
                                this.displayOptions.length - 1
                            );
                            this.scrollToHighlighted();
                        }
                        if (e.key === 'ArrowUp' && this.displayOptions.length > 0) {
                            this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);
                            this.scrollToHighlighted();
                        }
                        if (e.key === 'Enter' && this.displayOptions.length > 0) {
                            this.toggleOption(this.displayOptions[this.highlightedIndex]);
                        }
                        return;
                    }
                    if (e.key.length !== 1 || e.ctrlKey || e.altKey || e.metaKey) return;
                    if (this.resetNextType) { this.searchQuery = e.key; this.resetNextType = false; }
                    else { this.searchQuery += e.key; }
                    this.isOpen = true;
                }
            };
        };
    }
</script>
@endscript
