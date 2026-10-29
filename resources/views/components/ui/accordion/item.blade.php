@aware([
    'reverse' => false,
    'independent' => false,
])

@props([
    'disabled' => false,
    'trigger' => null,
    'expanded' => false,
    'variant' => 'bare',
])

@php
    $variantClasses = match ($variant) {
        'card'
            => 'bg-white dark:bg-neutral-800 border border-(--color-line-subtle) text-(--color-ink-strong)  rounded-button',
        default => '  text-(--color-ink-strong) not-last:border-b border-(--color-line-subtle) text-start',
    };
@endphp

<div role="region" @if ($expanded) data-expanded @endif x-data="{
    id: $id('accordion'),
    @if ($independent) active: null, @endif
    init() {
        if (@js($expanded)) {
            this.active = this.id;
        }
    },
    toggle() {
        this.isVisible = !this.isVisible;
    },
    get isVisible() {
        return this.active === this.id && !@js($disabled)
    },
    set isVisible(value) {
        this.active = value ? this.id : null
    },
}"
        {{ $attributes->class([$variantClasses, 'opacity-50' => $disabled]) }}>

    @if ($trigger)
        <x-ui.accordion.trigger>{{ $trigger }}</x-ui.accordion.trigger>
        <x-ui.accordion.content>{{ $slot }}</x-ui.accordion.content>
    @else
        {{ $slot }}
    @endif

</div>
