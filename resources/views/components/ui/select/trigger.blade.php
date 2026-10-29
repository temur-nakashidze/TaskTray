@aware([
    'icon' => '',
    'iconAfter' => 'ps:caret-down',
    'disabled' => false,
    'clearable' => false,
    'searchable' => false,
    'triggerClass' => '',
    'invalid' => false,
    'trigger' => null,
    'size' => 'default',
    'placeholder' => 'select...',
    'as' => 'default',
])

@php
    $buttonStyleClasses = [
        'bg-[color-mix(in_srgb,var(--color-outline)_8%,white)] hover:bg-[color-mix(in_srgb,var(--color-outline)_15%,white)] dark:bg-[color-mix(in_srgb,var(--color-outline)_15%,var(--color-neutral-900))] dark:hover:bg-[color-mix(in_srgb,var(--color-outline)_20%,var(--color-neutral-900))]',
        'border border-[var(--color-outline-content)]/40 hover:border-[var(--color-outline-content)]/50',
        'text-[var(--color-outline-fg)]/90 hover:text-[var(--color-outline-fg)]',
        '[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-outline-content)_12%,transparent),inset_0_-1px_4px_color-mix(in_srgb,var(--color-outline-fg)_10%,transparent)] hover:[box-shadow:inset_0_-2px_8px_color-mix(in_srgb,var(--color-outline-fg)_15%,transparent)] dark:[box-shadow:0_1px_2px_color-mix(in_srgb,var(--color-outline-shadow)_50%,transparent),inset_0_-1px_6px_color-mix(in_srgb,var(--color-outline)_10%,transparent)]',
        'active:shadow-[inset_0_2px_4px_color-mix(in_srgb,var(--color-outline-content)_20%,transparent)] active:bg-[color-mix(in_srgb,var(--color-outline)_22%,white)] dark:active:bg-[color-mix(in_srgb,var(--color-outline)_22%,var(--color-neutral-900))]',
        // neutral outline defaults — same as button's default outlineColors
        '[--color-outline:var(--color-neutral-300)] [--color-outline-content:var(--color-neutral-600)] [--color-outline-shadow:var(--color-neutral-950)] [--color-outline-fg:var(--color-neutral-700)]/90 dark:[--color-outline:var(--color-neutral-300)] dark:[--color-outline-content:var(--color-neutral-300)] dark:[--color-outline-fg:var(--color-neutral-100)]/90',
        match ($size) {
            'sm' => 'min-h-8 rounded-[calc(var(--radius-button)*0.75)]',
            default => 'min-h-10 rounded-button',
        },
        'font-medium text-sm transition-ui',
    ];
        $isButtonStyle = $as === 'button';
            $classes = $isButtonStyle ? [
    'border  text-start', // keep layout
    'col-span-4 col-start-1 row-start-1 justify-self-stretch flex items-center',
    'overflow-hidden whitespace-nowrap truncate',
    'disabled:opacity-35 px-1 disabled:cursor-default disabled:pointer-events-none cursor-pointer',
    'transition-ui',
    ...$buttonStyleClasses,
        ] :  [
                'border-red-500/80 border data-open:border-red-500/50' => $invalid,
                'border-(--color-line-base) disabled:border-(--color-line-subtle) data-open:border-(--color-line-strong)' => !$invalid,
                'border bg-white dark:bg-neutral-900/60 rounded-input text-start',
                'data-open:ring-2 data-open:ring-neutral-600/15 dark:data-open:ring-neutral-300/10 data-open:ring-offset-0 data-open:outline-none cursor-pointer',
                'col-span-4 col-start-1 row-start-1 justify-self-stretch flex items-center',
                'disabled:text-(--color-ink-subtle) disabled:placeholder-(--color-ink-subtle)  disabled:cursor-auto dark:disabled:bg-neutral-900/30 disabled:bg-neutral-50 disabled:shadow-none',
                'overflow-hidden whitespace-nowrap  text-(--color-ink-muted) hover:text-(--color-ink-base) shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-700)_8%,transparent)] dark:shadow-[inset_0_1px_4px_color-mix(in_srgb,var(--color-neutral-950)_40%,transparent)] text-sm truncate font-medium transition-color duration-200',
                match ($size) {
                    'sm' => 'min-h-8 p-0.5 ',
                    default => 'min-h-10 p-1 pl-2',
                },
            ];
@endphp

<div x-ref="trigger" x-on:click="handleButtonClick" {{-- wire:ignore.self --}} data-slot="trigger"
        {{ $attributes->class([
            'relative grid place-items-center grid-cols-[40px_1fr_auto]',
            '[&>[data-slot=icon]+[data-slot=select-control]]:pl-10',
            '[&_[data-slot=icon]]:opacity-40 [&_[data-slot=icon]]:cursor-auto' => $disabled,
        ]) }}>
    @if (filled($icon))
        <x-ui.icon :name="$icon" variant="fill"
                   class="col-span-1 ml-2 col-start-1 row-start-1 h-full w-full flex items-center justify-center z-10 !size-[1.40rem] text-(--color-ink-base)  "/>
    @endif

    <button type="button" aria-haspopup="listbox" x-bind:aria-expanded="__isOpen ? 'true' : 'false'"
            x-bind:aria-controls="$id('rover-options')" x-bind:aria-activedescendant="$rover.getActiveItemId() || false"
            x-bind:aria-multiselectable="__isMultiple || false" aria-label="{{ $placeholder }}"
            x-bind:data-open="__isOpen"
            data-slot="select-control" @class($classes) @disabled($disabled)>
        <span wire:ignore class="truncate self-center w-full pl-2 pr-8">
            <span x-ref:trigger-value>{{ $placeholder }}</span>
        </span>
    </button>

    @if (filled($iconAfter))
        <div data-slot="icon" @if ($clearable) x-show="!hasSelection" @endif x-cloak tabindex="0"
             class="col-start-3 row-start-1 pr-1.5  justify-self-center">
            <x-ui.icon :name="$iconAfter" @class([
                'text-(--color-ink-muted)',
                match ($size) {
                    'sm' => 'size-6 p-0.75',
                    default => 'size-7 p-1',
                },
            ]) />
        </div>
    @endif

    @if ($clearable)
        <div data-slot="select-clear" role="button" tabindex="0" aria-label="Clear selection" x-show="hasSelection"
             x-cloak x-on:click.stop="clear()" x-on:keydown.enter.stop="clear" x-on:keydown.space.prevent.stop="clear"
             x-bind:aria-disabled="!hasSelection" class="col-start-3 row-start-1 pr-1 justify-self-center">
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
