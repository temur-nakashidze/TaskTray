@props([
    'trigger' => null,
    'maxHeight' => 'max-h-21',
])

@php
    // Detect if the user wants a "not" condition
    $isNegative = str_starts_with($trigger, '!');
    $propertyName = $isNegative ? ltrim($trigger, '!') : $trigger;

    // Construct the Alpine-friendly string
    // Results in: $wire.unlimitedUsage or !$wire.unlimitedUsage
    $alpineTrigger = ($isNegative ? '!' : '') . '$wire.' . $propertyName;
@endphp

<div x-data x-show="{{ $alpineTrigger }}" x-cloak
    x-transition:enter="transition-all duration-200 ease-out overflow-hidden" x-transition:enter-start="opacity-0 max-h-0"
    x-transition:enter-end="opacity-100 {{ $maxHeight }}"
    x-transition:leave="transition-all duration-200 ease-in overflow-hidden"
    x-transition:leave-start="opacity-100 {{ $maxHeight }}" x-transition:leave-end="opacity-0 max-h-0"
    {{ $attributes }}>
    {{ $slot }}
</div>
