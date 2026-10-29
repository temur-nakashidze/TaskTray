@props([
    'align' => 'start',
    'variant' => null,
    'sticky' => false,
])

@php
    $classes = [
        '[:where(&)]:py-3 [:where(&)]:px-4 first:pl-2 last:pr-2 text-sm text-(--color-ink-base)',
        'sticky left-0' => $sticky
    ];
@endphp

<td {{ $attributes->class($classes) }}>
    {{ $slot }}
</td>
