<div
        {{ $attributes->class('flex gap-1.5 bg-[color-mix(in_srgb,var(--color-neutral-300)_15%,white)] dark:bg-[color-mix(in_srgb,var(--color-neutral-300)_15%,var(--color-neutral-900))]  px-2 text-base   items-center  text-(--color-ink-base) border   border-(--color-line-base) data-[slot=input-suffix]:rounded-r-input data-[slot=input-prefix]:rounded-l-input') }}
>
    {{ $slot }}
</div>