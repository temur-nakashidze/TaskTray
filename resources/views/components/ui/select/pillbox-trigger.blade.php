@aware([
    'iconAfter' => 'chevron-up-down',
    'disabled' => false,
    'clearable' => false,
    'searchable' => false,
    'triggerClass' => '',
    'invalid' => false,
    'trigger' => null,
    'placeholder' => 'select...',
    'size' => 'default',
])

@php
    $classes = [
        'border-red-500/80 border data-open:border-red-500/50' => $invalid,
        'border-(--color-line-base) data-open:border-(--color-line-strong)' => !$invalid,
        'border bg-white dark:bg-neutral-900/60 rounded-input text-start',
        'data-open:ring-2 data-open:ring-neutral-600/15 dark:data-open:ring-neutral-300/10 data-open:ring-offset-0 data-open:outline-none',
        'col-span-4 col-start-1 row-start-1 justify-self-stretch',
        'disabled:opacity-60 flex items-center disabled:cursor-auto cursor-pointer',
        'overflow-hidden whitespace-nowrap  text-(--color-ink-muted) hover:text-(--color-ink-base) shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_60%,transparent)] text-sm truncate font-medium transition-color duration-200',
        'col-span-4 col-start-1 row-start-1 justify-self-stretch',
        'overflow-hidden whitespace-nowrap text-start truncate flex flex-wrap',
        $triggerClass,
        match ($size) {
            'sm' => 'min-h-8 p-0.5 gap-0.5',
            default => 'min-h-10 p-1 gap-1',
        },
    ];
@endphp

<div x-ref="trigger" x-on:click="handleButtonClick" wire:ignore data-slot="trigger"
        {{ $attributes->class([
            'relative grid items-start justify-center grid-cols-[1fr_auto]',
            // when there is only one icon (iconAfter), give pillboxes container padding-right for single icon
            '[&:has([data-slot=select-control]+[data-slot=icon])>[data-slot=select-control]]:pr-9',
            '[&_[data-slot=icon]]:opacity-40 [&_[data-slot=icon]]:cursor-auto' => $disabled,
        ]) }}>
    {{-- tags --}}
    <div x-bind:aria-expanded="__isOpen.toString()" x-bind:aria-controls="$id('rover-options')"
         x-bind:aria-activedescendant="$rover.getActiveItemId() ?? false"
         x-bind:aria-multiselectable="__isMultiple ? 'true' : false" x-bind:aria-label="@js($placeholder)"
         x-bind:data-open="__isOpen" data-slot="select-control" @class($classes)
            @disabled($disabled)>
        <template x-for="(item, index) in selectedTags" x-bind:key="item.value">
            <div @class([
                "cursor-default inline-flex items-center rounded-md font-medium
                                 text-(--color-ink-base)   bg-neutral-600/10 dark:bg-neutral-300/10 border-(--color-line-base) border
                                max-w-full",
                match ($size) {
                    'sm' => 'text-xs px-1.5 py-0.5',
                    default => 'text-sm px-2 py-1',
                },
            ])>
                <span class="truncate" x-text="item.label"></span>

                <button type="button"
                        class="cursor-pointer ml-1 -mr-1 rounded-sm hover:bg-black/5 dark:hover:bg-white/10
                        focus:outline-none p-1"
                        x-on:click.stop="deselect(item.value)" data-slot="remove-btn"
                        x-bind:aria-label="'Remove ' + item.label">
                    <x-ui.icon name="ps:x" variant="bold" class="size-3"/>
                </button>
            </div>
        </template>

        <template x-if="selectedTags.length === 0">
            {{-- this is span isn't optional inside template... --}}
            <span class="pl-2 self-center">
                {{ $placeholder }}
            </span>
        </template>

        {{-- visible during Alpine boot, hidden the moment Alpine processes x-show="false"
            thuss templates has evaluated and rendered, creating a seamless handoff with zero flash --}}
        <span x-show="false" class="pl-2 self-center">
            {{ $placeholder }}
        </span>
    </div>

    @if (filled($iconAfter))
        <div data-slot="icon" @if ($clearable) x-show="!hasSelection" @endif x-cloak
             class="col-span-1 row-start-1 pt-1 pr-1 h-full justify-self-center [&:has(+[data-slot=select-clear])]:col-start-2 [&:not(:has(+[data-slot=select-clear]))]:col-start-3">
            <x-ui.icon :name="$iconAfter" @class([
                'rounded-md text-(--color-ink-muted)',
                match ($size) {
                    'sm' => 'size-6 p-0.75',
                    default => 'size-8 p-1',
                },
            ]) />
        </div>
    @endif

    @if ($clearable)
        <div class="col-span-1 row-start-1 cursor-pointer pt-1.5 pr-1.5 justify-self-center h-full col-start-3"
             x-bind:class="!hasSelection && 'opacity-50'" x-on:keydown.space.prevent.stop="clear"
             x-bind:aria-disabled="!hasSelection" x-on:keydown.enter.stop="clear" aria-label="Clear selection"
             data-slot="select-clear" x-on:click.stop="clear" x-show="hasSelection" role="button" tabindex="0"
             x-cloak>
            <x-ui.icon name="x-mark" @class([
                'rounded-md dark:hover:bg-white/5 hover:bg-neutral-800/5',
                match ($size) {
                    'sm' => 'size-6 p-0.75',
                    default => 'size-7 p-1',
                },
            ]) />
        </div>
    @endif
</div>
