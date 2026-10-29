@props([
    'separator' => null,
    'iconVariant' => 'mini',
    'icon' => null,
    'href' => null,
])

@php
    $classes = ['group/breadcrumbs flex items-center gap-x-0.5'];

    $linkClasses = [
        'text-(--color-ink-base) hover:text-(--color-ink-strong) transition-colors duration-150 font-normal text-sm flex items-center gap-x-1'
    ];

    $staticTextClasses = [
        ' text-(--color-ink-subtle)   text-sm flex items-center gap-x-1'
    ];

    $iconClasses = [
        'size-5' => $iconVariant === 'outline' 
    ];
@endphp

<div class="{{ Arr::toCssClasses($classes) }}">
    @if ($href)
        <a href="{{ $href }}" {{ $attributes->class(Arr::toCssClasses($linkClasses)) }}>
            @if ($icon)
                <x-ui.icon name="{{ $icon }}" variant="{{ $iconVariant }}"
                           class="{{ Arr::toCssClasses($iconClasses) }}"/>
            @endif
            {{ $slot }}
        </a>
    @else
        <div {{ $attributes->class(Arr::toCssClasses($staticTextClasses)) }}>
            @if ($icon)
                <x-ui.icon name="{{ $icon }}" variant="{{ $iconVariant }}"
                           class="{{ Arr::toCssClasses($iconClasses) }}"/>
            @endif
            {{ $slot }}
        </div>
    @endif

    @if ($separator == null)
        <x-ui.icon name="chevron-right" variant="mini"
                   class="group-last/breadcrumbs:hidden rtl:hidden text-(--color-ink-subtle)"/>
        <x-ui.icon name="chevron-left" variant="mini"
                   class="group-last/breadcrumbs:hidden hidden rtl:inline text-(--color-ink-subtle)"/>
    @elseif (!is_string($separator))
        {{ $separator }}
    @elseif ($separator === 'slash')
        <x-ui.icon name="slash" variant="mini"
                   class="group-last/breadcrumbs:hidden rtl:-scale-x-100 text-(--color-ink-subtle)"/>
    @else
        <x-ui.icon :name="$separator" variant="mini" class="group-last/breadcrumbs:hidden text-(--color-ink-subtle)"/>
    @endif
</div>
