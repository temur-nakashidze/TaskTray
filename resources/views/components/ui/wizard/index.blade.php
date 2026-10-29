@props([
    'contained' => false,
    'variant' => 'default',
])

@php
    $classes = [
        'flex flex-col w-full',
        'gap-[var(--gap-cards)]' => !$contained,
    ];
@endphp

<div
        {{ $attributes->class($classes) }}
>
    {{ $slot }}
</div>