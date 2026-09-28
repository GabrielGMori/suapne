@props(['action'])

@if(!$action->isLink($item))
<form action="{{ $action->getUrl($item) }}" method="{{ $action->getMethod($item) === 'GET' ? 'GET' : 'POST' }}">
    @csrf
    @if($action->needsDirective($item))
    @method($action->getMethod($item))
    @endif
    @endif

    <x-button :label="$action->needsConfirmation($item) ? 'Confirmar' : null"
        :size="$action->needsConfirmation($item) ? 'medium' : 'dynamic'"
        :type="$action->isLink($item) ? 'link' : 'submit'" :color="$action->getColor($item)"
        :icon="!$action->needsConfirmation($item) ? $action->getIcon($item) : null"
        :href="$action->isLink($item) ? $action->getUrl($item) : null" />

    @if(!$action->isLink($item))
</form>
@endif
