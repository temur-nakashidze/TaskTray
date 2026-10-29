@php use Illuminate\View\ComponentAttributeBag; @endphp
@aware([
    'collapsible' => false,
])
@props([
    'as' => 'a',
    'icon' => null,
    'iconSize' => 'md',
    'iconAfter' => null,
    'badge' => null,
    'label' => null,
    'href' => '#',
    'active' => null,
    'variant' => 'ghost',
    'iconVariant' => null,
    'size' => 'sm',
])

@php
    $sizeClasses = match ($size) {
        'lg' => 'px-4 py-2.5 [:has([data-collapsed]_&)_&]:p-3',
        default => 'px-2.5 py-2 [:has([data-collapsed]_&)_&]:p-2',
    };

    $variantClasses = match ($variant) {
        'outline' => [
            'bg-white dark:bg-neutral-800 border border-(--color-line-subtle)',
            'hover:bg-theme-500/10 hover:border-theme-500/60 dark:hover:border-theme-300/50',
            'text-(--color-ink-muted) hover:text-(--color-ink-strong) rounded-xl !px-4 !py-2',
        ],
        default => [
            '[&:not([data-active-link])]:dark:hover:text-theme-300 text-(--color-ink-muted)',
            '[&:not([data-active-link])]:hover:bg-theme-500/10
             [&:not([data-active-link])]:hover:text-theme-700
			 data-active-link:[&_[data-slot=icon]]:!text-theme-700
		 dark:data-active-link:[&_[data-slot=icon]]:!text-theme-300
		 [&:not([data-active-link])]:hover:[&_[data-slot=icon]]:!text-theme-700
		 [&:not([data-active-link])]:dark:hover:[&_[data-slot=icon]]:!text-theme-300',
        ],
    };

    $classes = [
        'relative isolate flex items-center transition-all duration-200 rounded-xl gap-x-2',
        '[:where(&)]:justify-start [:has([data-collapsed]_&)_&]:justify-center',

        $sizeClasses,

        // Active State
        'data-active-link:bg-theme-500/10
		data-active-link:dark:bg-theme-500/10
         data-active-link:text-theme-700
         data-active-link:dark:text-theme-300
         data-active-link:border-theme-300/80
         data-active-link:[&_[data-slot=icon]]:!text-theme-700',

        ...$variantClasses,

        // Icon Logic
        '[&_[data-slot=icon]]:dark:text-neutral-300 [&_[data-slot=icon]]:text-neutral-600 data-[active-link]:text-theme-700',

        // Loading CSS
        '[&>[data-loading=true]:first-child]:flex',
        '[&>[data-loading=true]:first-child~*]:opacity-0',
    ];

    $iconAttributes = new ComponentAttributeBag();
    $iconAfterAttributes = new ComponentAttributeBag();
    $badgeAttributes = new ComponentAttributeBag();
    foreach ($attributes->getAttributes() as $key => $value) {
        if (str_starts_with($key, 'icon:')) {
            $iconAttributes[substr($key, 5)] = $value;
        } elseif (str_starts_with($key, 'icon-after:')) {
            $iconAfterAttributes[substr($key, 11)] = $value;
        } elseif (str_starts_with($key, 'badge:')) {
            $badgeAttributes[substr($key, 6)] = $value;
        }
    }

    $active = $active ?? url($href) === url()->current();

    // Loading Logic
    $hasClickAction = filled($attributes->whereStartsWith('wire:click')->first());
    $hasWireLoading = filled($attributes->whereStartsWith('wire:loading')->first());
    $loadingAttributes = new ComponentAttributeBag();
    if ($hasWireLoading || $hasClickAction) {
        $loadingAttributes = $loadingAttributes->merge([
            'wire:loading.attr' => 'data-loading',
            'wire:target' => $attributes->has('wire:target')
                ? $attributes->get('wire:target')
                : $attributes->whereStartsWith('wire:click')->first(),
        ]);
    }
@endphp

@if ($as === 'button')
    <button type="button" @if ($active) data-active-link @endif data-slot="navlist-item"
            {{ $attributes->class($classes) }}>
        @else
            <a href="{{ $href }}" @if ($active) data-active-link @endif data-slot="navlist-item"
                    {{ $attributes->class($classes) }}>
                @endif

                {{-- Loading Indicator Overlay --}}
                <div @class([
    'absolute inset-0 hidden items-center justify-center bg-inherit rounded-box',
]) {{ $loadingAttributes }}>
                    <x-ui.icon.loading variant="micro" class="size-5"/>
                </div>

                {{-- Leading Icon --}}
                @if ($icon)
                    <x-ui.navlist.has-tooltip :tooltip="$label" :condition="$collapsible">
                        <x-ui.icon data-slot="icon" :name="$icon" :size="$iconSize" :variant="$iconVariant"
                                   :attributes="$iconAttributes->class('shrink-0')"/>
                    </x-ui.navlist.has-tooltip>
                @endif

                {{-- Label --}}
                <span class="text-base font-medium flex-1 truncate [:has([data-collapsed]_&)_&]:hidden">
    {{ $label }}
</span>

                {{-- Badge --}}
                @if ($badge)
                    <x-ui.badge pill :attributes="$badgeAttributes->merge([
        'size' => 'sm',
        'color' => 'red-amber',
    ])" class="[:has([data-collapsed]_&)_&]:hidden ml-auto shrink-0">
                        {{ $badge }}
                    </x-ui.badge>
                @endif

                {{-- Trailing Icon --}}
                @if ($iconAfter)
                    <x-ui.icon data-slot="icon-after" :name="$iconAfter" :size="$iconSize"
                               :attributes="$iconAfterAttributes->class('shrink-0 ml-auto [:has([data-collapsed]_&)_&]:hidden')"/>
        @endif

        @if ($as === 'button')
    </button>
    @else
        </a>
@endif
