@props([
    'level' => 'span', // h1–h6 for semantic headings, div/span for UI text
    'size' => 'sm',
    'weight' => 'medium', // light | normal | medium | semibold | bold
    'color' => 'ink', // ink | theme | accent | subtle | muted
    'href' => null,
    'font' => 'display',
])

@php
    $tag = in_array($level, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span']) ? $level : 'span';

    $fontClass = match ($font) {
        'mono' => 'font-mono',
        'label' => 'font-label',
        'sans' => 'font-sans',
        default => 'font-display',
    };

    $sizeClass = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl',
        default => 'text-base',
    };

    $trackingClass = match ($size) {
        '3xl', '2xl', 'xl' => 'tracking-tight',
        'xs' => 'tracking-wide',
        default => 'tracking-normal',
    };

    $weightClass = match ($weight) {
        'light' => 'font-light',
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'bold' => 'font-bold',
        'black' => 'font-black',
        default => 'font-semibold',
    };

    $colorClass = match ($color) {
        'theme' => 'text-(--color-theme-700) dark:text-(--color-theme-200)',
        'accent' => 'text-(--color-accent-700) dark:text-(--color-accent-300)',
        'subtle' => 'text-(--color-ink-strong) opacity-60',
        'muted' => 'text-(--color-ink-strong) opacity-80',
        default => 'text-(--color-ink-strong)',
    };

    $classes = [
        'text-start',
        $colorClass,
        'cursor-pointer hover:opacity-100 transition-all' => $href,
        $sizeClass,
        $trackingClass,
        $weightClass,
        $fontClass,
    ];
@endphp

<{{ $tag }} {{ $attributes->class(Arr::toCssClasses($classes)) }} data-slot="heading">
    @if ($href)
        <a href="{{ $href }}">{{ $slot }}</a>
    @else
        {{ $slot }}
    @endif
    </{{ $tag }}>
