{{-- resources/views/components/ui/hover-reveal/overlay.blade.php --}}
@props(['position' => 'bottom', 'class' => ''])

@php
    $positionClasses = match ($position) {
        'bottom' => 'bottom-0 left-0 right-0',
        'top' => 'top-0 left-0 right-0',
        'full' => 'inset-0',
        default => 'bottom-0 left-0 right-0',
    };
@endphp

<div
    {{ $attributes->class([
        'absolute z-10 transition-all duration-200',
        'opacity-0 translate-y-2',
        '@media(hover:none):opacity-100 @media(hover:none):translate-y-0',
        'group-hover:opacity-100 group-hover:translate-y-0',
        $positionClasses,
        $class,
    ]) }}>
    {{ $slot }}
</div>
