@aware(['size'])

@props([
    'id' => null,
    'count' => null,
    'independent' => false,
])

@php
    $classes = [
        'grid items-start w-full',
        $independent ? 'grid-rows-[auto_1fr_auto]' : 'grid-rows-subgrid row-span-full',
        'w-(--column-width)',
        'bg-(--color-raised)/50 dark:bg-(--color-neutral-800)/50',
        'rounded-item border border-(--color-line-subtle)',
    ];
@endphp

<div {{ $attributes->class($classes) }} data-slot="kanban-column">
    {{ $slot }}
</div>
