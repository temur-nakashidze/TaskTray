@aware(['variant' => 'outlined'])

@props([
    'name' => null,
])
@php
    $classes = match ($variant) {
        'outlined' => ['border border-neutral-600/20 dark:border-neutral-300/20 rounded-item', 'bg-white p-[var(--padding-box-lg)] dark:bg-neutral-800'],
        'non-contained' => ['mt-2'], // it's non contained broo, panels had freedom here.
    default => [],
};
$classes = ['text-start  text-(--color-ink-strong)', ...$classes];
@endphp

<div {{ $attributes->class($classes) }} data-slot="tabs-panel" style="display:none;"
     @if (filled($name)) data-name="{{ $name }}" @endif
     x-show="isActive({ name: @js($name), index: $el.dataset.panelOrder });">
    {{ $slot }}
</div>
