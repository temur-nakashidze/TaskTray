@props([
    'openInNewTab' => null,
    'primary' => true,
    'variant' => null,
])

@php
    $classes = [
        'inline font-semibold text-base text-start',
        'underline-offset-[6px] hover:decoration-current transition-color duration-200',
        match ($variant) {
            'ghost' => 'no-underline hover:underline',
            'soft' => 'no-underline',
            default => 'underline',
        },
        match ($variant) {
            'soft' => 'text-(--color-ink-muted) hover:text-(--color-ink-strong) dark:hover:text-white',
            default => match ($primary) {
                true
                    => 'text-[var(--color-theme-600)] decoration-[color-mix(in_oklab,var(--color-theme-600),transparent_80%)]',
                false => 'text-(--color-ink-strong) decoration-neutral-800/20 dark:decoration-white/20',
            },
        },
    ];
@endphp

<a {{ $attributes->class(Arr::toCssClasses($classes)) }} data-slot="link"
   @if ($openInNewTab) target="_blank" @endif>{{ $slot }}</a>
