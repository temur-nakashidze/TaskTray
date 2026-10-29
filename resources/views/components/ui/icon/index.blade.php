@props([
    'name' => null,
    'variant' => null,
    'size' => null,
    'asButton' => false,
])
@php
    $isPhosphorSet = str($name)->startsWith(['ps:', 'phosphor:']);
    $isHeroiconsSet = !$isPhosphorSet;

    $iconName = $isPhosphorSet ? str($name)->after(':') : $name;

    // variant only controls outline/solid/fill etc — not size
    $componentName = match (true) {
        $isPhosphorSet => match ($variant) {
            'thin', 'light', 'fill', 'regular', 'duotone', 'bold' => "phosphor.icons::{$variant}.{$iconName}",
            default => "phosphor.icons::regular.{$iconName}",
        },
        $isHeroiconsSet => match ($variant) {
            'solid' => "heroicons::solid.{$iconName}",
            'mini' => "heroicons::mini.solid.{$iconName}",
            'micro' => "heroicons::micro.solid.{$iconName}",
            default => "heroicons::outline.{$iconName}",
        },
    };

    $sizeClass = match ($size) {
        'xs' => 'size-4',
        'sm' => 'size-4.5',
        'lg' => 'size-6',
        'xl' => 'size-7',
        default => 'size-5', // md is default
    };

    // Only apply size class if no size/width/height is already set
    $hasCustomSize = str($attributes->get('class'))->contains(['size-', 'w-', 'h-']);
@endphp

@if ($asButton)
    <button {{ $attributes->class('cursor-pointer') }} type="button">
        @endif

        <x-dynamic-component :component="$componentName"
                             {{ $attributes->class([
                                 '[:where(&)]:text-(--color-ink-base)',
                                 $sizeClass => !$hasCustomSize,
                             ]) }}
                             data-slot="icon"/>

        @if ($asButton)
    </button>
@endif
