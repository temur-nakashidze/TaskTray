@php use Illuminate\View\ComponentAttributeBag; @endphp
@aware(['checkbox' => false, 'radio' => false, 'checkboxVariant' => false])

@props([
    'disabled' => false,
    'icon' => null,
    'iconVariant' => 'regular',
    'shortcut' => null,
    'variant' => 'soft',
    'as' => 'button',
    'active' => false,
    'value' => null,
    'name' => null,
    'checkboxVariant' => false,
    'readOnly' => false,
])

@php
    $isDefaultDropdownVariant = !($checkbox || $radio || $readOnly);

    $variantClasses = match ($variant) {
        'soft'
            => 'hover:bg-neutral-500/10 dark:hover:bg-neutral-300/10 text-(--color-text-base) hover:text-(--color-ink-strong) focus-within:bg-neutral-100  dark:focus-within:bg-white/5 px-3 py-2',
        'danger'
            => '!text-red-500 dark:!text-red-400 hover:text-red-600 hover:bg-red-500/5 dark:hover:bg-red-500/5 dark:hover:text-red-500 focus-within:text-red-600 focus-within:bg-red-50 dark:focus-within:bg-red-400/20 dark:focus-within:text-red-400',
        default => 'text-(--color-text-base) hover:text-(--color-ink-strong)',
    };

    $iconClasses = [
        'inline-flex shrink-0 mr-2',
        match ($variant) {
            'danger'
                => 'group-hover:text-red-500! dark:group-hover:text-red-400! group-focus-within:text-red-500! dark:group-focus-within:text-red-400!',
            default => '',
        },
    ];

    $iconAttributes = new Illuminate\View\ComponentAttributeBag()
        ->class($iconClasses)
        ->merge(['aria-hidden' => 'true']);

    $value ??= trim($slot->__toString());

    $hasClickAction = filled($attributes->whereStartsWith('wire:click')->first());

    $loadingAttributes = new ComponentAttributeBag();
    if ($hasClickAction) {
        $loadingAttributes = $loadingAttributes->merge([
            'wire:loading.attr' => 'data-loading',
            'wire:target' => $attributes->whereStartsWith('wire:click')->first(),
        ]);
    }

    $classes = [
        'grid grid-cols-subgrid group relative overflow-hidden',
        'col-span-2' => $isDefaultDropdownVariant,
        'col-span-3' => !$isDefaultDropdownVariant,
        'w-full px-2 py-1.5 text-sm transition-colors duration-100 text-start',
        'text-(--color-ink-base) font-medium',
        'rounded-popup-item',
        'focus-within:outline-none',
        'data-active:bg-neutral-950/[3%] dark:data-active:bg-white/[3%]',
        'paint-order-stroke-fill',
        'text-rendering-optimize-legibility',
        '[-webkit-font-smoothing:antialiased]',
        '[font-smooth:always]',
        '[&>[data-loading=true]:first-child]:flex [&>[data-loading=true]:first-child~*]:opacity-0' => $hasClickAction,
        $variantClasses . ' cursor-pointer' => !$disabled,
        'opacity-50 cursor-not-allowed ' => $disabled,
    ];

    if ($active) {
        $attributes['data-active'] = 'true';
    }
@endphp

@if ($isDefaultDropdownVariant)
    <x-ui.button.abstract :$as :attributes="$attributes->class(Arr::toCssClasses($classes))->merge([
        'disabled' => $disabled,
        'tabindex' => $disabled ? '-1' : '0',
        'aria-disabled' => $disabled ? 'true' : 'false',
        'role' => 'menuitem',
    ])" data-slot="dropdown-item">

        {{-- Loading Indicator --}}
        @if ($hasClickAction)
            <div class="absolute inset-0 hidden items-center justify-center bg-inherit rounded-[inherit]"
                    {{ $loadingAttributes }}>
                <x-ui.icon.loading variant="micro" class="size-4"/>
            </div>
        @endif

        @if (filled($icon))
            <x-ui.icon :name="$icon" :variant="$iconVariant" :attributes="$iconAttributes" data-slot="right-icon"/>
        @endif

        <span class="col-start-2 whitespace-nowrap flex items-center justify-between gap-4">
            <span class="flex-1">{{ $slot }}</span>

            @if (filled($shortcut))
                <x-ui.kbd>
                    {{ $shortcut }}
                </x-ui.kbd>
            @endif
        </span>
    </x-ui.button.abstract>
@elseif($readOnly)
    <div class="text-center col-span-full w-full px-3 py-1.5 text-sm" {{ $attributes }}>
        {{ $slot }}
    </div>
@else
    <x-ui.dropdown.checkbox-or-radio :$attributes :$classes :$iconClasses :$value>
        {{ $slot }}
    </x-ui.dropdown.checkbox-or-radio>
@endif
