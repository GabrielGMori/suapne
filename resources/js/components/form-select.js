export function formSelectData(options, isMultiple, selected) {
    return {
        isOpen: false,
        searchQuery: "",
        searchTimeout: null,
        resetNextType: false,
        highlightedIndex: 0,
        selected,
        options,
        isMultiple,

        get selectedSet() {
            return new Set(this.selected);
        },

        get labelMap() {
            return Object.fromEntries(
                this.options.map((option) => [option.value, option.label]),
            );
        },

        get selectedWithLabels() {
            return this.selected.map((value) => ({
                value,
                label: this.labelMap[value] ?? value,
            }));
        },

        normalize(value) {
            return value
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/\s+/g, "");
        },

        fuzzyMatch(query, text) {
            let index = 0;

            for (const character of text) {
                if (character === query[index]) {
                    index++;
                }

                if (index === query.length) {
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

            return this.fuzzyMatch(query, text) ? 500 : -1;
        },

        get displayOptions() {
            if (!this.searchQuery) {
                return this.options;
            }

            return this.options
                .map((option) => ({
                    option,
                    score: this.scoreSearch(this.searchQuery, option.label),
                }))
                .filter((item) => item.score >= 0)
                .sort((a, b) => b.score - a.score)
                .map((item) => item.option);
        },

        isSelected(value) {
            return this.selectedSet.has(value);
        },

        toggleOption(option) {
            if (this.isMultiple) {
                this.selected = this.isSelected(option.value)
                    ? this.selected.filter((value) => value !== option.value)
                    : [...this.selected, option.value];
            } else {
                this.selected = [option.value];
                this.isOpen = false;
            }

            this.resetSearch();
        },

        removeOption(value) {
            this.selected = this.selected.filter(
                (selectedValue) => selectedValue !== value,
            );
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
                this.$refs.menu
                    ?.querySelectorAll(
                        ".select-option:not(.cursor-not-allowed)",
                    )
                    [
                        this.highlightedIndex
                    ]?.scrollIntoView({ block: "nearest" });
            });
        },

        handleKeydown(event) {
            if (event.key === "Backspace" && this.searchQuery.length) {
                event.preventDefault();
                this.searchQuery = this.searchQuery.slice(0, -1);
                this.isOpen = true;
                return;
            }

            if (
                ["ArrowDown", "ArrowUp", "Enter", "Escape"].includes(event.key)
            ) {
                if (event.key === "Escape") {
                    this.isOpen = false;
                    return;
                }

                if (!this.isOpen) {
                    event.preventDefault();
                    this.isOpen = true;
                    return;
                }

                event.preventDefault();

                if (event.key === "ArrowDown" && this.displayOptions.length) {
                    this.highlightedIndex =
                        (this.highlightedIndex + 1) %
                        this.displayOptions.length;
                }

                if (event.key === "ArrowUp" && this.displayOptions.length) {
                    this.highlightedIndex =
                        (this.highlightedIndex -
                            1 +
                            this.displayOptions.length) %
                        this.displayOptions.length;
                }

                if (event.key === "Enter" && this.displayOptions.length) {
                    this.toggleOption(
                        this.displayOptions[this.highlightedIndex],
                    );
                }

                this.scrollToHighlighted();
                return;
            }

            if (
                event.key.length !== 1 ||
                event.ctrlKey ||
                event.altKey ||
                event.metaKey
            ) {
                return;
            }

            if (event.key === " ") {
                event.preventDefault();
            }

            this.searchQuery = this.resetNextType
                ? event.key
                : this.searchQuery + event.key;

            this.resetNextType = false;
            this.isOpen = true;

            clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(() => {
                this.resetNextType = true;
            }, 1000);
        },
    };
}
