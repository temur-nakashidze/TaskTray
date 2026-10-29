@props([
    'vertical' => false,
    'variant' => '',
    'label' => null,
])

@php
    $orientation = $vertical ? 'vertical' : 'horizontal';

    $lineClasses = [
        'border-0',

        'mx-2' => $orientation === 'vertical',
        'my-1' => $orientation === 'horizontal',
        match ($orientation) {
            'vertical' => filled($label) ? 'w-px grow' : 'w-px self-stretch shrink-0',
            'horizontal' => filled($label) ? 'h-px flex-1' : 'h-px w-full',
        },
        match ($variant) {
            'subtle' => 'bg-neutral-600/10 dark:bg-neutral-300/10',
            default => 'bg-neutral-600/15 dark:bg-neutral-300/10',
        },
    ];

    $lineClasses = Arr::toCssClasses($lineClasses);
@endphp

@if (!filled($label))
    @if ($orientation === 'vertical')
        <div data-orientation="{{ $orientation }}" {{ $attributes->class($lineClasses) }} role="separator"
             aria-orientation="{{ $orientation }}" data-slot="separator"></div>
    @else
        {{-- we need to make the element can contributes to space-y-* likely if we don't use flex --}}
        <div data-orientation="{{ $orientation }}" {{ $attributes->class('w-full') }} data-slot="separator"
             role="separator" aria-orientation="{{ $orientation }}">
            <div class="{{ $lineClasses }}"></div>
        </div>
    @endif
@else
    @if ($orientation === 'vertical')
        <div {{ $attributes->merge(['class' => 'flex flex-col justify-center items-center self-stretch mx-1']) }}
             data-slot="separator" role="separator" aria-orientation="{{ $orientation }}"
             aria-label="{{ $label }}">
            <div class="{{ $lineClasses }}" aria-hidden="true"></div>
            <div class="text-sm leading-none text-(--color-ink-muted) pb-[0.22rem] whitespace-nowrap">
                {{ $label }}
            </div>
            <div class="{{ $lineClasses }}" aria-hidden="true"></div>
        </div>
    @else
        <div data-orientation="{{ $orientation }}"
             {{ $attributes->merge(['class' => 'flex items-center w-full my-4']) }} role="separator"
             aria-orientation="{{ $orientation }}" aria-label="{{ $label }}" data-slot="separator">
            <div class="{{ $lineClasses }}" aria-hidden="true"></div>
            <span class="shrink-0 mx-6 font-medium text-sm text-(--color-ink-muted) whitespace-nowrap">
                {{ $label }}
            </span>
            <div class="{{ $lineClasses }}" aria-hidden="true"></div>
        </div>
    @endif
@endif
