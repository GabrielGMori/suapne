@php
    use Illuminate\Support\Facades\Auth;
    use App\Enums\RoleEnum;

    $id = $filter->getIdentifier() ?? $filter->getKey();

    $mask = $filter->getMask();    
@endphp

@if(!$filter->isTrashedFilter() || Auth::user()->role === RoleEnum::DOCENTE_ESPECIAL)
    @if(in_array($filter->getType(), ['select', 'multiselect']))
        <livewire:form.select
            :key="$prefix.$id"
            :type="$filter->getType()"
            :name="$id"
            :label="$filter->getLabel()"
            :options="$filter->getOptions()"
            :placeholder="$filter->getPlaceholder()"
            :clearable="$filter->isClearable()"
            :size="$filter->getSize()"
            appearance="outlined"
            wire:model.live.debounce.300ms="filtersStates.{{ $id }}"
        />
    @else
            <x-form.input
                :key="$prefix.$id"
                :type="$filter->getType()"
                :name="$id"
                :label="$filter->getLabel()"
                :placeholder="$filter->getPlaceholder()"
                :size="$filter->getSize()"
                appearance="outlined"
                wire:model.live.debounce.300ms="filtersStates.{{ $id }}"

                :mask="$mask"
            />
    @endif
@endif
