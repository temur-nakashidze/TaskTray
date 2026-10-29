@aware([ 'variant' => 'outlined', 'size' => 'default'])

@props([
    'label' => null,
    'name' => null,
    'iconAfter' => null,
    'icon' => null,
    'iconVariant' => null,
    'iconClasses' => null,
])

@php
    $classes = match($variant){
        'outlined' => [
            'p-3 dark:border-neutral-300/20 border-neutral-600/20 rounded-button rounded-b-none justify-center focus:outline-none focus:bg-white/5 hover:bg-white/5',
            'data-[active=true]:bg-white dark:data-[active=true]:bg-neutral-800',
            'data-[active=true]:border-b-0', // Remove bottom border when active
            'data-[active=true]:border',
        ],
        'non-contained' => [
            'data-[active=true]:bg-white dark:data-[active=true]:bg-neutral-800  text-(--color-ink-strong)',
            'hover:bg-white/50 dark:hover:bg-neutral-800/50 focus:bg-white', // focus and hover
            'rounded-button', // those variables are defined on the group wrapper
            'border border-transparent data-[active=true]:border-neutral-600/20 dark:data-[active=true]:border-neutral-300/20'
        ],
        'pills' => [
            'rounded-full bg-white/50 dark:bg-neutral-900/50  text-(--color-ink-base)   border border-neutral-600/20 h-10 whitespace-nowrap rounded-full text-sm font-medium',
            'data-[active=true]:border-neutral-600/60 data-[active=true]:bg-white dark:data-[active=true]:bg-neutral-800 dark:data-[active=true]:bg-border-300/80 data-[active=true]:text-(--color-ink-strong)'
        ],
        default => [],
    };

    // if tab has name we need to bind it, so we can prirotize it then in orders
    // we can mutate the AttributeBag Objet as an array, it implement \ArrayAccess interafce
    if(filled($name)) $attributes['data-name'] = $name;
@endphp

<x-ui.button
        :attributes="$attributes->class(Arr::toCssClasses($classes))"
        x-on:click="handleTabClick($el)"
        data-slot="tab"
        tabindex="0"
        variant="none"
>
    @if($slot->isNotEmpty())
        <span class="flex-1">{{ $slot }}</span>
    @else
        {{ $label }}
    @endif
</x-ui.button>
