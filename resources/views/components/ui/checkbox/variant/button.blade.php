@aware([
    'disabled' => null,
    'invalid' => null,
    'size' => null,
    'variant' => null,
    'label' => null,
    'description' => null,
    'indicator' => true,
])

@props([
    'label' => null,
    'icon' => '',
    'iconVariant' => 'regular',
    'iconClass' => '',
])

@php
    $showIcon = filled($icon);

    $classes = [
        // Layout
        'flex items-center justify-center gap-2 px-4 h-10 w-fit cursor-pointer rounded-button',
        'text-sm font-medium transition-all duration-200 isolate relative overflow-hidden',

        // Base Visuals (Matching Card visuals)
        'bg-white dark:bg-neutral-800 border border-neutral-300/30 dark:border-neutral-700/30',
        'text-(--color-ink-base)',

        // Hover
        'hover:bg-neutral-100/50 dark:hover:bg-neutral-700/50 hover:border-neutral-300 dark:hover:border-neutral-600',

        // Checked State (Matching Card visuals)
        'data-[checked]:bg-primary/15 data-[checked]:border-primary',
        'data-[checked]:text-[var(--color-primary-content)]',

        // Disabled
        'opacity-50 cursor-not-allowed' => $disabled,
    ];
@endphp

<div x-bind:data-checked="_checked && !_indeterminate" x-bind:data-indeterminate="_indeterminate"
     x-bind:aria-checked="_indeterminate ? 'mixed' : (_checked ? 'true' : 'false')"
     x-bind:aria-invalid="@js($invalid) ? 'true' : null" x-ref="checkboxControl"
     x-on:click="!@js($disabled) && toggle()"
     x-on:keydown.space.prevent="!@js($disabled) && toggle()"
     x-on:keydown.enter.prevent="!@js($disabled) && toggle()" tabindex="{{ $disabled ? '-1' : '0' }}"
     type="button" role="checkbox" {{ $attributes->class($classes) }}>
    @if ($showIcon)
        <x-ui.icon name="{{ $icon }}" variant="{{ $iconVariant }}" class="size-4.5 {{ $iconClass }}"/>
    @endif

    <span>{{ $label ?? $slot }}</span>
</div>
