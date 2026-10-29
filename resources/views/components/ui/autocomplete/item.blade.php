@props([
    'value' => null,
    'label' => null,
    'disabled' => false,
    'allowCustomSlots' => false
])

@php
    $value = filled($value) ? $value : $slot->__toString();
    $label = filled($label) ? $label : $slot->__toString();

    $classes = [
        "select-none cursor-pointer rounded-popup-item group self-center gap-x-2 items-center",
        "focus:bg-neutral-100 focus:dark:bg-neutral-700 px-3 py-2 w-full text-sm transition-all duration-100   text-(--color-ink-base)   hover:text-(--color-ink-strong) font-medium",
        '[&[aria-disabled=true]]:pointer-events-none [&[aria-disabled=true]]:opacity-50',
        'data-active:bg-neutral-500/10 dark:data-active:bg-neutral-500/10',
        '[ul:is([data-loading])>&]:hidden',
    ];
@endphp

<li
        data-label="{{ $label }}"
        value="{{ $value }}"
        data-slot="autocomplete-item"
        x-rover:option
        {{-- morph will remove data-value for none changed els so the init ain't re-run --}}
        wire:ignore.self

        @if($disabled) disabled aria-disabled="true" @endif

        {{ $attributes->class($classes) }}
>
    {{ $slot }}
</li>
