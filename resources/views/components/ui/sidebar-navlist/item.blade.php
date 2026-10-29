@aware([
    'collapsible' => true,
])
@props([
    'icon' => null,
    'badge' => null,
    'label' => null,
    'href' => '#',
    'active' => null,
    'iconVariant' => 'regular',
    'iconSize' => 'md',
    'badgeVariant' => 'solid',
])

@php
    $classes = [
        'relative isolate',
        'flex font-medium items-center',
        'data-active-link:bg-neutral-500/10
         data-active-link:text-theme-700
			dark:data-active-link:text-theme-300
         data-active-link:[&_[data-slot=icon]]:!text-theme-700
		 dark:data-active-link:[&_[data-slot=icon]]:!text-theme-300',
        // removed hover:bg — the flying box handles it now
        '[&:not([data-active-link])]:hover:text-(--color-ink-base)
         [&:not([data-active-link])]:hover:[&_[data-slot=icon]]:!text-(--color-ink-base)',
        'text-(--color-ink-muted)',
        '[&_[data-slot=icon]]:text-(--color-ink-base)',
        'gap-x-3 px-3 py-2.5 rounded-popup-item transition-colors duration-150',
    ];

    $badgeAttributes = new \Illuminate\View\ComponentAttributeBag();
    foreach ($attributes->getAttributes() as $key => $value) {
        if (str_starts_with($key, 'badge:')) {
            $badgeAttributes[substr($key, 6)] = $value;
        }
    }

    $active = $active ?? url($href) === url()->current();
@endphp

<a href="{{ $href }}" @if ($active) data-active-link @endif data-slot="sidebar-navlist-item"
    {{ $attributes->class($classes) }} @mouseenter="move($el)" @mouseleave="reset()">
    @if ($icon)
        <x-ui.sidebar-navlist.has-tooltip :tooltip="$label" :condition="$collapsible">
            <x-ui.icon :name="$icon" :variant="$iconVariant" :size="$iconSize" data-slot="icon" class="size-5" />
        </x-ui.sidebar-navlist.has-tooltip>
    @endif

    <span data-slot="sidebar-navlist-label"
        class="text-base whitespace-nowrap overflow-hidden transition-[max-width,opacity] duration-300 ease-in-out">
        {{ $label }}
    </span>

    @if ($badge)
        <x-ui.badge data-slot="badge" variant="{{ $badgeVariant }}" pill :attributes="$badgeAttributes->merge([
            'size' => 'sm',
            'color' => 'red',
        ])" class="ml-auto">
            {{ $badge }}
        </x-ui.badge>
    @endif
</a>
