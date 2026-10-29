<div @class([
    'grid items-center justify-center px-(--popup-padding) mb-(--popup-padding) grid-cols-[20px_1fr]', // give the icon 20 px and leave the input take the rest
    '[&>[data-slot=icon]+[data-slot=search-control]]:pl-8', // because there is an icon give it 6 padding
    'w-full border-b py-(--popup-padding) border-(--color-line-subtle) pb-2.5 px-2.5',
])>
    <x-ui.icon name="magnifying-glass"
               class="absolute !text-neutral-500 dark:!text-neutral-400 !size-5 ml-1.5"/>

    <input x-rover:input {{-- stop the input event from bubbling up to prevent the input
        value from been bounded to the actual state --}} {{ $attributes }} x-on:input.stop data-slot="search-control"
           placeholder="ძიება..." type="text" @class([
            'h-8 placeholder:text-(--color-ink-subtle) text-base text-(--color-ink-strong)',
            'col-span-4 col-start-1 row-start-1',
             'border border-(--color-line-base) focus:border-(--color-line-strong) p-2 w-full text-sm  text-(--color-ink-strong) placeholder-neutral-400  ',
            'bg-white dark:bg-neutral-900/80',
            'transition-colors duration-200',
            'rounded-input shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)] ',
            'focus:ring-0 focus:ring-offset-0 focus:outline-none focus:ring-neutral-600/15 dark:focus:ring-neutral-300/10',
        ])>
</div>
