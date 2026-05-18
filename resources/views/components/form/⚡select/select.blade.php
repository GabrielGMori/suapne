@php
    $baseClass     = "form-control form-control-{$appearance} form-control-{$size}";
    $submittedName = $isMultiple && $name && ! str_ends_with($name, '[]') ? "{$name}[]" : $name;
    $caretClass    = 'form-caret' . ($size === 'small' ? ' form-caret-small' : '');
@endphp

<div class="form-field {{ $size === 'full' ? '' : 'w-max' }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label form-label-{{ $appearance }}">{{ $label }}</label>
    @endif

    <div class="form-control-wrap">
        <div
            class="select form-control-{{ $size }}"
            role="combobox"
            aria-haspopup="listbox"
            tabindex="0"
            x-data="{
                isOpen: false,
                searchQuery: '',
                searchTimeout: null,
                resetNextType: false,
                highlightedIndex: 0,
                selected: @entangle('selectedItems'),
                options: @js($options),
                isMultiple: @js($isMultiple),

                get selectedSet() {
                    return new Set(this.selected);
                },

                get labelMap() {
                    return Object.fromEntries(this.options.map(o => [o.value, o.label]));
                },

                get selectedWithLabels() {
                    return this.selected.map(v => ({ value: v, label: this.labelMap[v] ?? v }));
                },

                get displayOptions() {
                    if (! this.searchQuery) return this.options;
                    const q = this.searchQuery.toLowerCase();
                    return this.options
                        .filter(o => o.label.toLowerCase().includes(q))
                        .sort((a, b) => a.label.toLowerCase().indexOf(q) - b.label.toLowerCase().indexOf(q));
                },

                isSelected(value) {
                    return this.selectedSet.has(value);
                },

                toggleOption(opt) {
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
                    this.selected = this.selected.filter(v => v !== value);
                },

                clearSelections() {
                    this.selected = [];
                },

                resetSearch() {
                    this.resetNextType = true;
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = null;
                },

                scrollToHighlighted() {
                    this.$nextTick(() => {
                        if (! this.$refs.menu) return;
                        const nodes = this.$refs.menu.querySelectorAll('.select-option:not(.cursor-not-allowed)');
                        if (nodes[this.highlightedIndex]) {
                            nodes[this.highlightedIndex].scrollIntoView({ block: 'nearest' });
                        }
                    });
                },

                handleKeydown(e) {
                    if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(e.key)) {
                        if (e.key === 'Escape') { this.isOpen = false; return; }
                        if (! this.isOpen) { e.preventDefault(); this.isOpen = true; return; }
                        e.preventDefault();
                        if (e.key === 'ArrowDown' && this.displayOptions.length > 0) {
                            this.highlightedIndex = (this.highlightedIndex + 1) % this.displayOptions.length;
                            this.scrollToHighlighted();
                        }
                        if (e.key === 'ArrowUp' && this.displayOptions.length > 0) {
                            this.highlightedIndex = this.highlightedIndex - 1 < 0
                                ? this.displayOptions.length - 1
                                : this.highlightedIndex - 1;
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
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => { this.resetNextType = true; }, 1000);
                }
            }"
            x-init="
                $watch('isOpen', v => {
                    if (! v) { searchQuery = ''; resetNextType = false; highlightedIndex = 0; }
                });
                $watch('searchQuery', () => { highlightedIndex = 0; });
            "
            x-bind:aria-expanded="isOpen"
            x-on:keydown="handleKeydown"
            x-on:click.outside="isOpen = false"
        >
            <button
                type="button"
                class="select-control {{ $baseClass }}"
                x-on:click="isOpen = !isOpen"
            >
                <div x-show="selected.length > 0" class="w-full text-left">
                    <template x-if="isMultiple">
                        <div class="select-chips">
                            <template x-for="item in selectedWithLabels" :key="item.value">
                                <span class="select-chip">
                                    <button type="button" class="select-chip-remove"
                                        x-on:click.stop="removeOption(item.value)"
                                        :aria-label="'Remover ' + item.label"
                                    >&times;</button>
                                    <span x-text="item.label" :title="item.label"></span>
                                </span>
                            </template>
                        </div>
                    </template>

                    <template x-if="!isMultiple">
                        <span class="block truncate" x-text="labelMap[selected[0]] ?? selected[0]"></span>
                    </template>
                </div>

                <span x-show="selected.length === 0" class="text-black/40">{{ $placeholder }}</span>
            </button>

            <button
                type="button"
                class="select-clear"
                x-show="selected.length > 0 && (isMultiple || {{ $clearable ? 'true' : 'false' }})"
                x-on:click="clearSelections()"
                aria-label="Limpar seleção"
            >&times;</button>

            <div
                x-show="isOpen"
                x-cloak
                x-ref="menu"
                class="select-menu"
                role="listbox"
                :aria-multiselectable="isMultiple"
            >
                <template x-if="displayOptions.length === 0">
                    <div class="select-option text-black/50 cursor-not-allowed" role="option" aria-disabled="true">
                        Sem resultados
                    </div>
                </template>

                <template x-for="(option, index) in displayOptions" :key="option.value">
                    <button
                        type="button"
                        class="select-option"
                        role="option"
                        :aria-selected="isSelected(option.value)"
                        x-bind:class="{
                            'select-option-selected': isSelected(option.value),
                            'bg-black/5': highlightedIndex === index
                        }"
                        x-on:click="toggleOption(option)"
                        x-on:mouseenter="highlightedIndex = index"
                    >
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
                    <input type="hidden" name="{{ $name }}" x-bind:value="selected[0]" />
                </template>
            @endif

            <span
                x-show="selected.length === 0 || (!isMultiple && !{{ $clearable ? 'true' : 'false' }})"
                class="{{ $caretClass }}"
                aria-hidden="true"
            ></span>
        </div>
    </div>
</div>