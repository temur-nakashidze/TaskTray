@props([
    'iconVariant' => 'micro',
    'iconAfter' => null,
    'variant' => null,
    'pill' => false,
    'color' => null,
    'size' => null,
    'icon' => null,
    'font' => 'label',
])
@php
    $fontClass = match ($font) {
        'mono' => 'font-mono',
        default => 'font-label',
    };
    if ($variant === 'outline') {
        $colorClasses = match ($color) {
            default
                => ' text-(--color-ink-base) bg-neutral-200/20 dark:bg-neutral-800/20 border-neutral-600/50 dark:border-neutral-300/50 border',
            'red'
                => 'text-red-700 dark:text-red-300 bg-red-200/20 dark:bg-red-800/20 border-red-900/40 dark:border-red-400/50 border',
            'orange'
                => 'text-orange-700 dark:text-orange-300 bg-orange-200/20 dark:bg-orange-800/20 border-orange-700/40 dark:border-orange-400/40 border',
            'amber'
                => 'text-amber-700 dark:text-amber-300 bg-amber-200/20 dark:bg-amber-800/20 border-amber-700/40 dark:border-amber-400/40 border',
            'yellow'
                => 'text-yellow-700 dark:text-yellow-300 bg-yellow-200/20 dark:bg-yellow-800/20 border-yellow-700/40 dark:border-yellow-400/40 border',
            'lime'
                => 'text-lime-700 dark:text-lime-300 bg-lime-200/20 dark:bg-lime-800/20 border-lime-700/40 dark:border-lime-400/40 border',
            'green'
                => 'text-green-700 dark:text-green-300 bg-green-200/20 dark:bg-green-800/20 border-green-700/40 dark:border-green-400/40 border',
            'emerald'
                => 'text-emerald-700 dark:text-emerald-300 bg-emerald-200/20 dark:bg-emerald-800/20 border-emerald-700/40 dark:border-emerald-400/40 border',
            'teal'
                => 'text-teal-700 dark:text-teal-300 bg-teal-200/20 dark:bg-teal-800/20 border-teal-700/40 dark:border-teal-400/40 border',
            'cyan'
                => 'text-cyan-700 dark:text-cyan-300 bg-cyan-200/20 dark:bg-cyan-800/20 border-cyan-700/40 dark:border-cyan-400/40 border',
            'sky'
                => 'text-sky-700 dark:text-sky-300 bg-sky-200/20 dark:bg-sky-800/20 border-sky-700/40 dark:border-sky-400/40 border',
            'blue'
                => 'text-blue-700 dark:text-blue-300 bg-blue-200/20 dark:bg-blue-800/20 border-blue-700/40 dark:border-blue-400/40 border',
            'indigo'
                => 'text-indigo-700 dark:text-indigo-300 bg-indigo-200/20 dark:bg-indigo-800/20 border-indigo-700/40 dark:border-indigo-400/40 border',
            'violet'
                => 'text-violet-700 dark:text-violet-300 bg-violet-200/20 dark:bg-violet-800/20 border-violet-700/40 dark:border-violet-400/40 border',
            'purple'
                => 'text-purple-700 dark:text-purple-300 bg-purple-200/20 dark:bg-purple-800/20 border-purple-700/40 dark:border-purple-400/40 border',
            'fuchsia'
                => 'text-fuchsia-700 dark:text-fuchsia-300 bg-fuchsia-200/20 dark:bg-fuchsia-800/20 border-fuchsia-700/40 dark:border-fuchsia-400/40 border',
            'pink'
                => 'text-pink-700 dark:text-pink-300 bg-pink-200/20 dark:bg-pink-800/20 border-pink-700/40 dark:border-pink-400/40 border',
            'rose'
                => 'text-rose-700 dark:text-rose-300 bg-rose-200/20 dark:bg-rose-800/20 border-rose-700/40 dark:border-rose-400/40 border',
            'primary'
                => 'text-theme-700 dark:text-theme-300 bg-theme-200/20 dark:bg-theme-800/20 border-theme-700/40 dark:border-theme-400/40 border',
            'accent'
                => 'text-accent-700 dark:text-accent-300 bg-accent-200/20 dark:bg-accent-800/20 border-accent-700/40 dark:border-accent-400/40 border',
        };
    } elseif ($variant === 'soft') {
        $colorClasses = match ($color) {
            default => ' text-(--color-ink-base) bg-neutral-300/40 dark:bg-neutral-700/30 border border-transparent',
            'red' => 'text-red-700 dark:text-red-200 bg-red-300/40 dark:bg-red-700/30 border border-transparent',
            'orange'
                => 'text-orange-700 dark:text-orange-200 bg-orange-300/40 dark:bg-orange-700/30 border border-transparent',
            'amber'
                => 'text-amber-700 dark:text-amber-200 bg-amber-300/40 dark:bg-amber-700/30 border border-transparent',
            'yellow'
                => 'text-yellow-700 dark:text-yellow-200 bg-yellow-300/40 dark:bg-yellow-700/30 border border-transparent',
            'lime' => 'text-lime-700 dark:text-lime-200 bg-lime-300/40 dark:bg-lime-700/30 border border-transparent',
            'green'
                => 'text-green-700 dark:text-green-200 bg-green-300/40 dark:bg-green-700/30 border border-transparent',
            'emerald'
                => 'text-emerald-700 dark:text-emerald-200 bg-emerald-300/40 dark:bg-emerald-700/30 border border-transparent',
            'teal' => 'text-teal-700 dark:text-teal-200 bg-teal-300/40 dark:bg-teal-700/30 border border-transparent',
            'cyan' => 'text-cyan-700 dark:text-cyan-200 bg-cyan-300/40 dark:bg-cyan-700/30 border border-transparent',
            'sky' => 'text-sky-700 dark:text-sky-200 bg-sky-300/40 dark:bg-sky-700/30 border border-transparent',
            'blue' => 'text-blue-700 dark:text-blue-200 bg-blue-300/40 dark:bg-blue-700/30 border border-transparent',
            'indigo'
                => 'text-indigo-700 dark:text-indigo-200 bg-indigo-300/40 dark:bg-indigo-700/30 border border-transparent',
            'violet'
                => 'text-violet-700 dark:text-violet-200 bg-violet-300/40 dark:bg-violet-700/30 border border-transparent',
            'purple'
                => 'text-purple-700 dark:text-purple-200 bg-purple-300/40 dark:bg-purple-700/30 border border-transparent',
            'fuchsia'
                => 'text-fuchsia-700 dark:text-fuchsia-200 bg-fuchsia-300/40 dark:bg-fuchsia-700/30 border border-transparent',
            'pink' => 'text-pink-700 dark:text-pink-200 bg-pink-300/40 dark:bg-pink-700/30 border border-transparent',
            'rose' => 'text-rose-700 dark:text-rose-200 bg-rose-300/40 dark:bg-rose-700/30 border border-transparent',
            'primary'
                => 'text-theme-700 dark:text-theme-200 bg-theme-300/40 dark:bg-theme-700/30 border border-transparent',
            'accent'
                => 'text-accent-700 dark:text-accent-200 bg-accent-300/40 dark:bg-accent-700/30 border border-transparent',
        };
    } else {
        $colorClasses = match ($color) {
            default => 'text-white dark:text-white bg-neutral-500 dark:bg-neutral-500 border-neutral-500',
            'red' => 'text-white dark:text-white bg-red-500 dark:bg-red-500 border-red-400 dark:border-red-400/90',
            'orange'
                => 'text-white dark:text-white bg-orange-500 dark:bg-orange-500 border-orange-500 dark:border-orange-500',
            'amber'
                => 'text-white dark:text-white bg-amber-500 dark:bg-amber-500 border-amber-500 dark:border-amber-500',
            'yellow'
                => 'text-white dark:text-white bg-yellow-500 dark:bg-yellow-500 border-yellow-500 dark:border-yellow-500',
            'lime' => 'text-white dark:text-white bg-lime-500 dark:bg-lime-500 border-lime-500 dark:border-lime-500',
            'green'
                => 'text-white dark:text-white bg-green-500 dark:bg-green-500 border-green-500 dark:border-green-500',
            'emerald'
                => 'text-white dark:text-white bg-emerald-500 dark:bg-emerald-500 border-emerald-500 dark:border-emerald-500',
            'teal' => 'text-white dark:text-white bg-teal-500 dark:bg-teal-500 border-teal-500 dark:border-teal-500',
            'cyan' => 'text-white dark:text-white bg-cyan-500 dark:bg-cyan-500 border-cyan-500 dark:border-cyan-500',
            'sky' => 'text-white dark:text-white bg-sky-500 dark:bg-sky-500 border-sky-500 dark:border-sky-500',
            'blue' => 'text-white dark:text-white bg-blue-500 dark:bg-blue-500 border-blue-500 dark:border-blue-500',
            'indigo'
                => 'text-white dark:text-white bg-indigo-500 dark:bg-indigo-500 border-indigo-500 dark:border-indigo-500',
            'violet'
                => 'text-white dark:text-white bg-violet-500 dark:bg-violet-500 border-violet-500 dark:border-violet-500',
            'purple'
                => 'text-white dark:text-white bg-purple-500 dark:bg-purple-500 border-purple-500 dark:border-purple-500',
            'fuchsia'
                => 'text-white dark:text-white bg-fuchsia-500 dark:bg-fuchsia-500 border-fuchsia-500 dark:border-fuchsia-500',
            'pink' => 'text-white dark:text-white bg-pink-500 dark:bg-pink-500 border-pink-500 dark:border-pink-500',
            'rose' => 'text-white dark:text-white bg-rose-500 dark:bg-rose-500 border-rose-500 dark:border-rose-500',
            'neutral'
                => 'text-white dark:text-white bg-neutral-500 dark:bg-neutral-500 border-neutral-500 dark:border-neutral-500',
            'primary'
                => 'text-white dark:text-white bg-theme-500 dark:bg-theme-500 border-theme-500 dark:border-theme-500',
            'accent'
                => 'text-white dark:text-white bg-accent-500 dark:bg-accent-500 border-accent-500 dark:border-accent-500',
        };
    }

    $classes = [
        'inline-flex items-center
		font-medium  whitespace-nowrap gap-x-0.5',
        $colorClasses,
        $fontClass,
        match ($size) {
            'xs' => 'text-[11px] py-[0.07rem] !px-[0.3rem]',
            'sm' => 'text-xs py-[0.14rem] !px-[0.4rem]',
            'lg' => 'text-lg py-[0.2rem]',
            default => 'text-base py-[0.2rem]',
        },
        match ($pill) {
            true => 'rounded-full px-3.5',
            default => 'rounded-sm px-2',
        },
    ];

    $iconClasses = [
        match ($size) {
            'sm' => 'size-4 mr-.5',
            'lg' => 'size-5 mr-1',
            default => 'size-4.5 mr-1',
        },
    ];

@endphp


<span {{ $attributes->class(Arr::toCssClasses($classes)) }} data-slot="badge">

    @if (is_string($icon) && $icon !== '')
        <x-ui.icon :name="$icon" :variant="$iconVariant" class="{{ Arr::toCssClasses($iconClasses) }}"
            data-slot="badge-icon" />
    @else
        {{ $icon }}
    @endif

    {{ $slot }}

    @if ($iconAfter)
        @if (is_string($iconAfter))
            <x-ui.icon :name="$iconAfter" :variant="$iconVariant" class="{{ Arr::toCssClasses($iconClasses) }}"
                data-slot="badge-icon:after" />
        @else
            {{ $iconAfter }}
        @endif
    @endif
</span>
