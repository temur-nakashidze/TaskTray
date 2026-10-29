@aware([
    'position' => 'bottom-center',
    'offset' => 3,
])

@props([
    'position' => 'bottom-center',
    'offset' => 3,
])

@php
    // Map intuitive names to Alpine Anchor (Floating UI) position strings
    $anchorPosition = match ($position) {
        'bottom-left' => 'bottom-start',
        'bottom-center' => 'bottom',
        'bottom-right' => 'bottom-end',
        'top-left' => 'top-start',
        'top-center' => 'top',
        'top-right' => 'top-end',
        'left-top' => 'left-start',
        'left-center' => 'left',
        'left-bottom' => 'left-end',
        'right-top' => 'right-start',
        'right-center' => 'right',
        'right-bottom' => 'right-end',
        default => $position,
    };
@endphp

<x-ui.popup :attributes="$attributes->merge([
    'x-anchor.' . $anchorPosition . '.offset.' . $offset => '$refs.popoverTrigger',
    'class' => str($attributes->get('class'))->contains(['!w-']) ? '' : 'w-max',
    'x-show' => 'popoverOpen',
    'x-on:click.away' => 'hide()',
    'x-on:contextmenu.stop' => '',
    'x-on:keydown.escape.stop' => 'hide()',
])">
    {{ $slot }}
</x-ui.popup>
