@aware(['size'])

@props([
    'id' => null,
    'top' => null,
    'bottom' => null,
    'footer' => null,
    'handle' => null,
    'size' => 'md',
])

@php
    $classes = [
        'group relative rounded-input',
        'bg-(--color-raised)/50 border border-(--color-line-subtle)',
        'hover:border-(--color-theme-600)/25 dark:hover:border-(--color-theme-600)/60 hover:bg-(--color-theme-600)/3 shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-400)_5%,transparent)] dark:shadow-[0_0_10px_color-mix(in_srgb,var(--color-neutral-950)_5%,transparent)] transition duration-200',
    ];
@endphp

<div {{ $attributes->class($classes) }} data-slot="kanban-card">
    @if ($handle)
        <div data-drag-handle
            class="absolute top-3 right-1.5 opacity-0 group-hover:opacity-100 transition-opacity cursor-grab">
            <x-ui.icon name="ps:dots-six-vertical" class="text-(--color-theme-600) dark:text-(--color-theme-300)" />
        </div>
    @endif

    <div @class([
        'flex flex-col gap-1',
        match ($size) {
            // add more variants
            'sm' => 'px-3 py-2',
            'xs' => 'px-2 py-1.5',
            default => 'px-1 py-1',
        },
    ])>
        @if ($top)
            <div {{ $top?->attributes }}>
                {{ $top }}
            </div>
        @endif
        <div class="px-1.5 pt-1.5">
            {{ $slot }}
        </div>
        @if ($bottom)
            <div {{ $bottom?->attributes }}>
                {{ $bottom }}
            </div>
        @endif
        @if ($footer)
            <div
                {{ $footer?->attributes->merge(['class' => 'mt-0.5 px-1 pt-1 w-full border border-(--color-line-subtle) rounded-sm bg-(--color-sunken)/25 ']) }}>
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
