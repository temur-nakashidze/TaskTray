@php
    $classes = [
        'cursor-pointer flex items-center justify-center select-none col-span-full group self-center gap-x-2 items-center',
        ' px-3  w-full text-base',
        'rounded-[calc(var(--radius-button)*0.75)] p-2  h-8 active:shadow-[inset_0_2px_5px_color-mix(in_srgb,var(--color-neutral-600)_20%,transparent)] active:bg-[color-mix(in_srgb,var(--color-neutral-100)_22%,white)] dark:active:bg-[color-mix(in_srgb,var(--color-neutral-300)_22%,var(--color-neutral-900))] dark:active:shadow-[inset_0_2px_5px_color-mix(in_srgb,var(--color-neutral-900)_40%,transparent)]',
        'bg-[color-mix(in_srgb,var(--color-neutral-100)_15%,white)] hover:bg-[color-mix(in_srgb,var(--color-neutral-100)_25%,white)] dark:bg-[color-mix(in_srgb,var(--color-neutral-300)_15%,var(--color-neutral-950))] dark:hover:bg-[color-mix(in_srgb,var(--color-neutral-300)_20%,var(--color-neutral-950))]',
        'border border-[var(--color-neutral-600)]/30 hover:border-[var(--color-neutral-600)]/50 ',
        'text-[var(--color-neutral-700)]/90 hover:text-[var(--color-neutral-700)] dark:text-[var(--color-neutral-100)]/90 dark:hover:text-[var(--color-neutral-100)]',
     '[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-neutral-600)_15%,transparent),inset_0_-1px_4px_color-mix(in_srgb,var(--color-neutral-700)_10%,transparent)] hover:[box-shadow:inset_0_-2px_6px_color-mix(in_srgb,var(--color-neutral-700)_15%,transparent)] dark:[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-neutral-900)_90%,transparent),inset_0_-1px_6px_color-mix(in_srgb,var(--color-neutral-300)_10%,transparent)] transition-all duration-200'
    ];
@endphp

<li
        data-slot="create-option"
        x-data="CreateNewOptionActivator"
        wire:key="create-option"
        {{ $attributes->class($classes) }}
>
    {{ $slot }}
</li>
