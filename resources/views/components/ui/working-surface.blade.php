{{-- resources/views/components/ui/work-surface.blade.php --}}
@props([
    'spacing' => 30,
    'dotSize' => 1,
    'dotOpacity' => 30,
    'noiseOpacity' => 2,
])

<div {{ $attributes->class('relative overflow-hidden') }}
    style="
        --surface-spacing: {{ $spacing }}px;
        --surface-dot-size: {{ $dotSize }}px;
        --surface-dot-opacity: {{ $dotOpacity }}%;
        --surface-noise-opacity: {{ $noiseOpacity }}%;
    ">
    {{-- Background --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0"
        style="
            background-image:
                radial-gradient(
                    circle,
                    color-mix(in srgb, var(--color-neutral-500) var(--surface-dot-opacity), transparent)
                    var(--surface-dot-size),
                    transparent var(--surface-dot-size)
                ),
                repeating-linear-gradient(
                    0deg,
                    transparent 0px,
                    transparent 1px,
                    color-mix(in srgb, var(--color-neutral-500) var(--surface-noise-opacity), transparent) 1px,
                    color-mix(in srgb, var(--color-neutral-500) var(--surface-noise-opacity), transparent) 2px
                );
            background-size:
                var(--surface-spacing) var(--surface-spacing),
                3px 3px;
        ">
    </div>

    {{-- Content --}}
    <div class="relative">
        {{ $slot }}
    </div>
</div>
