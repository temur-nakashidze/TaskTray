@aware([
    'disabled' => false,
    'icon'        => 'ps:clock',
    'placeholder' => 'select a time',
    'clearable' => false,
    'iconAfter'   => 'chevron-up-down',
])

@props(['iconSize'])

<div
        x-bind:data-open="__isOpen"
        data-slot="select-control"
        x-on:click="handleButtonClick"
        x-bind:data-state-filled="hasValue"
        {{  $attributes->class([
                'col-span-full col-start-1 row-start-1 min-w-0 justify-self-stretch',
                'flex flex-wrap gap-1 items-center data-state-filled:items-start w-full cursor-pointer',
                'min-h-10 pl-1 pr-10',
            ]) }}
>
    <x-ui.icon
            :name="$icon"
            variant="bold"
            class="col-start-1 ml-1 mr-0.5 row-start-1 z-10 !size-[1.1rem] opacity-80 pointer-events-none place-self-center justify-self-center text-(--color-ink-base)"
    />
    {{-- Selected time chips --}}
    <template x-for="chip in selectedItems" x-bind:key="chip.value">
        <div @class([
                    'bg-neutral-600/10  text-(--color-ink-base) dark:bg-neutral-300/10  ',
                    'inline-flex items-center rounded-md font-medium shrink-0 max-w-full',
                    'border border-neutral-600/30 dark:border-neutral-300/30',
                    'text-sm pl-2 pr-1 py-1',
                ])>
            <span x-text="chip.label" class="tabular-nums"></span>
            <button
                    type="button"
                    x-on:click.stop="removeChip(chip.value)"
                    tabindex="-1"
                    aria-label="Remove"
                    class="rounded hover:bg-neutral-200 dark:hover:bg-neutral-600 p-0.25 opacity-60 hover:opacity-100 transition-opacity ml-1"
            >
                <x-ui.icon name="x-mark" variant="micro" class="size-4"/>
            </button>
        </div>
    </template>

    {{-- Placeholder shown only when nothing selected --}}
    <span
            x-show="!hasValue"
            class="text-(--color-ink-muted) text-sm select-none"
    >{{ $placeholder }}</span>
</div>

{{-- the buttons: clear and chevron trigger --}}
<span
        class="col-start-2 self-start row-start-1 px flex items-center gap-0.5 z-10 rounded hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors mt-1 mr-1"
>
    @if ($clearable)
        <button
                type="button"
                x-show="hasValue"
                x-cloak
                x-on:click.stop="clear"
                tabindex="-1"
                aria-label="Clear all"
        >
            <x-ui.icon name="x-mark" @class($iconSize) />
        </button>
    @endif

    <x-ui.icon
            :name="$iconAfter"
            x-show="!hasValue"
            x-rover:button
        @class([$iconSize, 'text-(--color-ink-muted)'])
    />
</span>