@props([
    'opacity' => 55,
    'thickness' => 0.5,
    'dash' => 28,
    'gap' => 18,
    'radius' => 4,
    'color' => 'var(--color-neutral-600)',
    'darkColor' => 'var(--color-neutral-300)',
])

<div {{ $attributes->class('lane-box') }}
    style="
        --lane-opacity: {{ $opacity }}%;
        --lane-thickness: {{ $thickness }}px;
        --lane-dash: {{ $dash }}px;
        --lane-gap: {{ $gap }}px;
        --lane-radius: {{ $radius }}px;
        --lane-color: {{ $color }};
        @if ($darkColor) --lane-color-dark: {{ $darkColor }}; @endif
    ">
    <svg class="absolute inset-0 size-full overflow-visible" aria-hidden="true" preserveAspectRatio="none">
        <rect x="0" y="0" width="100%" height="100%" rx="{{ $radius }}" ry="{{ $radius }}" fill="none"
            stroke="var(--lane-color)" stroke-width="{{ $thickness }}"
            stroke-dasharray="{{ $dash }} {{ $gap }}" opacity="{{ $opacity / 100 }}"
            vector-effect="non-scaling-stroke" />

        @if ($darkColor)
            <style>
                .dark .lane-box rect {
                    stroke: var(--lane-color-dark);
                }
            </style>
        @endif
    </svg>

    <div class="relative">
        {{ $slot }}
    </div>
</div>
