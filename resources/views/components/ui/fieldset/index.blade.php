@props([
    'label' => null,
    'labelHidden' => false,
])

@php
    $classes = [
        'rounded-item border border-(--color-line-subtle) p-[var(--padding-box-lg)] bg-white dark:bg-neutral-800 text-start capitalize',
        '[&>[data-slot=field]]:my-0
        [&>[data-slot=field]:not(:first-of-type)]:my-2
        [&>[data-slot=field]:not(:first-of-type)]:my-2',
    ];
@endphp
<fieldset {{ $attributes->class(Arr::toCssClasses($classes)) }}>
    @if (filled($label))
        <legend @class([
            '-ms-1 text-lg font-medium leading-6  text-(--color-ink-base)  ',
            'sr-only' => $labelHidden,
        ])>
            {{ $label }}
        </legend>
    @endif
    <div class="space-y-[var(--padding-box-lg)]">
        {{ $slot }}
    </div>
</fieldset>
