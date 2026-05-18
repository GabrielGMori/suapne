@if(in_array($filter->getType(), ['select', 'multiselect']))
    <livewire:form.select
        :key="$prefix.$filter->getKey()"
        :type="$filter->getType()"
        :name="$filter->getKey()"
        :label="$filter->getLabel()"
        :options="$filter->getOptions()"
        :placeholder="$filter->getPlaceholder()"
        :clearable="$filter->isClearable()"
        :size="$filter->getSize()"
        appearance="outlined"
        wire:model.live="filtersState.{{ $filter->getKey() }}"
    />
@else
    <livewire:form.input
        :key="$prefix.$filter->getKey()"
        :type="$filter->getType()"
        :name="$filter->getKey()"
        :label="$filter->getLabel()"
        :placeholder="$filter->getPlaceholder()"
        :size="$filter->getSize()"
        appearance="outlined"
        wire:model.live.debounce.300ms="filtersState.{{ $filter->getKey() }}"
    />
@endif