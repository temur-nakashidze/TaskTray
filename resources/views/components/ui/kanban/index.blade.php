@props([
    'size' => 'md', // sm, md, lg
])

@php
    $columnWidth = match ($size) {
        'sm' => '16rem',
        'lg' => '24rem',
        default => '20rem',
    };

    $classes = [
        'grid grid-flow-col auto-cols-[minmax(var(--column-width),1fr)] overflow-x-auto relative w-full gap-(--gap-layout)',
        'grid-rows-[auto_1fr_auto]',
    ];
@endphp

<div {{ $attributes->class($classes) }} style="--column-width: {{ $columnWidth }}" data-slot="kanban-board">
    {{ $slot }}
</div>
