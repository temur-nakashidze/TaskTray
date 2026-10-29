@aware([
    'onHover' => false,
])
@props([
    'onHover' => false,
])

<div x-ref="popoverTrigger"
    @if ($onHover) x-on:mouseover="show()"
        x-on:mouseleave="hide()" @endif
    x-on:click="toggle()" x-on:contextmenu.stop
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center cursor-pointer p-0 m-0 leading-none']) }}>
    {{ $slot }}
</div>
