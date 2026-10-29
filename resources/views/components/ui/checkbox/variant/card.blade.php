@aware([
    'disabled' => false,
    'invalid' => null,
    'size' => null,
    'labelSize' => null,
    'variant' => 'default',
    'label' => null,
    'description' => null,
    'indicator' => true,
    'icon' => '',
    'iconVariant' => 'regular',
    'iconClass' => '',
    'badge' => '',
])


@php
    $isCards = $variant === 'cards';
    $showIcon = filled($icon);
    $showBadge = filled($badge);

    $containerClasses = [
        'relative isolate transition duration-200 text-base group grid gap-3 p-4 w-full text-start cursor-pointer',

        // Responsive grid: adjusts if indicator is present
        $indicator ? 'grid-cols-[1fr_24px]' : 'grid-cols-1',

        $disabled ? 'opacity-30 cursor-pointer' : 'cursor-pointer',

        'dark:bg-neutral-600/20 bg-neutral-200/15 rounded-button border border-neutral-500/30 dark:border-neutral-300/20',
        'dark:hover:bg-neutral-600/40 hover:bg-neutral-300/20 hover:border-neutral-600/50 dark:hover:border-neutral-600 shadow-xs shadow-neutral-600/10 dark:shadow-neutral-950/30',

        'data-[checked=true]:bg-theme-500/20 data-[checked=true]:border-theme-500 hover:data-[checked=true]:bg-theme-500/20 hover:data-[checked=true]:border-theme-500',
        'data-[checked=true]:[&_label]:text-[var(--color-theme-700)] dark:data-[checked=true]:[&_label]:text-[var(--color-theme-200)]',
    ];

    $labelClasses = [
        'flex-1 cursor-pointer text-sm font-semibold flex items-center gap-2 transition duration-200',
        'text-(--color-ink-base) group-hover:text-(--color-ink-strong)',
    ];
@endphp

<div {{ $attributes->class($containerClasses) }} x-bind:data-checked="_checked && !_indeterminate"
    x-bind:data-indeterminate="_indeterminate" x-ref="checkboxControl" x-on:click="toggle()"
    x-on:keydown.space.prevent="toggle()" x-on:keydown.enter.prevent="toggle()" tabindex="{{ $disabled ? '-1' : '0' }}"
    type="button" role="checkbox">
    {{-- Click Overlay --}}
    <span class="absolute size-full inset-0 z-0"></span>

    <div class="col-start-1 flex flex-col gap-1.5 z-10">
        {{-- Label & Icon Row --}}
        <div class="flex items-center">

            <label @class($labelClasses)>
                @if ($showIcon)
                    <x-ui.icon name="{{ $icon }}" variant="{{ $iconVariant }}"
                        class="size-5 {{ $iconClass }}" />
                @endif
                <span>{{ $label ?? $slot }}</span>
            </label>
            @if ($showBadge)
                <x-ui.badge variant="outline" color="accent" size="sm">{{ $badge }}</x-ui.badge>
            @endif
        </div>

        {{-- Description --}}
        @if ($description)
            <p class="text-(--color-ink-muted)   text-sm pl-0!">
                {{ $description }}
            </p>
        @endif
    </div>

    {{-- Optional Indicator --}}
    @if ($indicator)
        <div class="col-start-2 flex justify-end items-start z-10">
            <x-ui.checkbox.indicator class="ml-auto group-hover:bg-transparent" />
        </div>
    @endif
</div>
