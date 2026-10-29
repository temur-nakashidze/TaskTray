@props(['checkboxId' => null])

@php
    $spanClasses = [
        'size-6 rounded-input border',
        'border-neutral-600/30 dark:border-neutral-300/40',
        'peer-checked:border-[var(--color-theme-600)]/80 dark:peer-checked:border-[var(--color-theme-300)]/80',
        'peer-checked:bg-[var(--color-theme-500)]',
        'peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[var(--color-theme-500)]',
        '[&:is(:where(.peer)[data-state=indeterminate]~*)]:bg-[var(--color-theme-500)]',
        '[&:is(:where(.peer)[data-state=indeterminate]~*)]:border-[var(--color-theme-600)]',
        'bg-white dark:bg-neutral-900',
        'shadow-[inset_0_1.5px_3px_rgba(0,0,0,0.05)]',
        'shadow-xs shadow-neutral-600/15',
        'transition-all duration-200',
    ];
@endphp

<label
        @class([
            "relative inline-grid place-items-center size-6 cursor-pointer",
            $attributes->get('class')
        ])
        @if ($checkboxId)
            wire:key="{{ $checkboxId }}"
        @endif
>
    <input
            {{ $attributes->except('class') }}

            @if ($checkboxId)
                value="{{ $checkboxId }}"
            @endif

            type="checkbox"
            wire:ignore
            class="peer absolute inset-0 opacity-0 cursor-pointer"
    >

    <span @class($spanClasses)></span>
    {{-- Checked state indicator --}}
    <x-ui.icon name="ps:check" size="sm" variant="bold"
               class="absolute text-neutral-50 opacity-0  peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200"/>

    {{-- Indeterminate state indicator --}}
    <span
            class="absolute w-3 h-0.5 rounded bg-neutral-50 opacity-0 [&:is(:where(.peer)[data-state=indeterminate]~*)]:opacity-100 transition-all duration-200"
    ></span>
</label>